#import "@local/mindtape:0.2.0": *

#show: task.with(
  id: "5d8c53fb-eeaa-4a06-be6f-e07568d50e05",
  title: "Throw typed ApiException on non-2xx responses",
  status: done(2026, 4, 18),
  priority: 7,
  x-paogen: (spec: "truth/specs/operation-generator.typ", decision: "truth/decisions/009-error-response-policy.typ", legacy-id: "T-012"),
)

== Summary

4xx / 5xx responses currently land in `hydrate()` and throw
`RuntimeException('Cannot hydrate … from non-array data.')`. There is
no typed error body, no exception class, no status-code mapping. Task
001's out-of-scope list already flags that a future scenario must
formalise what to throw.

== Rationale

Pre-release review P1 #11 — coverage gap; also called out in the
"suggested ordering toward a credible 0.1.0 tag".
`error-response-policy` (proposed) recommends a single generic
`ApiException` as the v0.1 shape.

== In scope

+ Promote the draft "non-2xx throws a typed exception" scenario on
  the Operation Generator to `stage: unstable` on implementation.
+ Emit a `Generated\\ApiException extends \\RuntimeException`
  class per the interface sketched in `error-response-policy`:
  `getStatusCode()`, `getRequest()`, `getResponse()`,
  `getDecodedBody(): mixed`.
+ Teach every emitted operation method to branch on HTTP status:
  2xx → existing happy-path; otherwise construct and throw the
  exception.
+ Cover at least one scenario where the declared 4xx response schema
  is `$ref`-to-Model: the hydrator *does not* attempt to construct
  the Model; it stays raw in `getDecodedBody()`.
+ Regenerate the Petstore golden fixture.
+ Update `error-response-policy`'s status to `accepted` if the
  implementation matches; otherwise supersede with the chosen shape.

== Non-goals

- Per-schema exception subclasses — explicitly rejected by
  `error-response-policy` for v0.1.
- Result-type return (`Ok|Err`) — rejected by `error-response-policy`.
- Retry / backoff logic on 5xx — belongs to user-side decorators
  (`profile-driven-generation`).

== Acceptance criteria

- The non-2xx scenario is promoted from `draft` to `unstable` and
  locked.
- `Generated\\ApiException` appears in the Petstore golden tree.
- A regression test fires a 404 through the fake PSR-18 client and
  asserts the exception shape.
- `just check` green end-to-end.
