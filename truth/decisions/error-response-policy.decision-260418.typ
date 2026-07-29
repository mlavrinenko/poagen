#import "@local/speconaut:0.1.0": *
#import "../domain/generation.context.typ": *

#show: decision.with(
  title: "Error response policy: non-2xx handling in the generated client",
  status: accepted(2026, 4, 18),
  contexts: (generation-context,),
  goals: (link("../goals/typed-injectable-surface.goal.typ"),),
  standards: (link("../standards/caller-surface-is-injectable.standard-260729.typ"),),
)

== Context

The pre-release review (P1 #11) and the Operation Generator's out-of-scope
list both flag that non-2xx responses currently fall into the generic
`hydrate()` path and throw
`RuntimeException('Cannot hydrate … from non-array data.')`. There is no
typed error body, no exception class per schema, and no status-code
mapping.

=== Options considered

#table(
  columns: (auto, 1fr, 1fr),
  [*Option*], [*Pros*], [*Cons*],
  [(a) Typed exception per error schema],
  [Consumer-side `catch` is as precise as the schema allows; IDE
   autocomplete on error bodies],
  [Generator complexity balloons (one class per 4xx/5xx schema);
   cross-cutting "rate-limited" errors explode into N near-identical
   classes; schema authors rarely type errors rigorously],

  [(b) Single generic `ApiException`],
  [Smallest generator footprint; consumer gets status + raw decoded
   body on one object; easy to special-case in user code],
  [Loses compile-time knowledge of declared error schemas; consumer
   must re-parse `getDecodedBody()` to reach schema-typed fields],

  [(c) Result-type return (`Ok|Err` union)],
  [No exceptions in the happy path; forces the consumer to handle
   failure at the call site],
  [Non-idiomatic PHP; requires every method return type to change;
   consumer code becomes `if ($r instanceof Err)` everywhere],
)

== Choice

Accepted: (b) single generic `ApiException` for the PoC and v0.1, with an
explicit upgrade path to (a) when a real schema justifies it.

Specifically:

+ Emit one generator-owned exception class — e.g.
  `Generated\\ApiException extends \\RuntimeException`.
+ The class exposes:
  - `getStatusCode(): int`
  - `getRequest(): Psr\\Http\\Message\\RequestInterface`
  - `getResponse(): Psr\\Http\\Message\\ResponseInterface`
  - `getDecodedBody(): mixed` (best-effort JSON decode; `null` on
    non-JSON or decode failure)
+ Any non-2xx status in any emitted operation throws this exception
  instead of being fed to `hydrate()`.
+ When an OpenAPI operation declares a typed 4xx/5xx response schema,
  #the(Generator) emits the exception's `@phpstan-return` / property
  type as the union of declared error #the(Model) types (no new
  exception subclasses). Consumers narrow via `instanceof` on
  `getDecodedBody()`. This keeps today's "one class per schema" budget
  at one even for richly-typed error surfaces.
+ Escalating to (a) is a future decision, triggered when at least one
  validation-tier schema (see
  #link("schema-fixture-policy.decision-260418.typ")[Schema fixture policy: vendor real-world OpenAPI documents under tests/fixtures/schemas/]) has a typed error body that
  consumers want to catch structurally, not by status code.

The implementing task tracks this build; a concrete alternative would
have to supersede this decision with a new one.

== Consequences

- The Operation Generator grows a "response-dispatch" step that
  distinguishes 2xx from everything else; the existing `ReturnSpec` /
  `ResponseHandler` pair gets a matching error branch.
- `Generated\\ApiException` is the first runtime support class #the(Generator)
  ships. The no-inheritance rule holds — this class is generated, and
  consumers extend nothing.
- The Petstore golden fixture regenerates with a new exception file and
  error branches in every method.
- The test harness gains at least one scenario per direction: "404
  throws `ApiException`", "`getDecodedBody()` returns the decoded
  payload", "non-JSON error body yields `null` decoded body".

=== Alternatives rejected

- *Status quo (generic `RuntimeException`).* Documented-broken by the
  review; swallows status code; unusable from consumer try/catch.
- *PSR-18 `ClientExceptionInterface`-only.* PSR-18 covers transport
  failures, not HTTP semantics. Wrong layer.
