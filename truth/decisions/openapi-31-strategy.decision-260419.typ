#import "@local/speconaut:0.1.0": *
#import "../domain/schema.context.typ": *

#show: decision.with(
  title: "Strategy for OpenAPI 3.1 support",
  status: superseded(2026, 7, 29),
  contexts: (schema-context,),
  goals: (link("../goals/real-world-schemas.goal.typ"),),
  standards: (link("../standards/fixtures-are-unmodified-vendor-documents.standard-260729.typ"),),
)

== Context

poagen currently consumes OpenAPI 3.0 via `cebe/php-openapi`. The
pre-release review (P1 #14) and `truth/notes/openapi-3.1-gap.md` both
flag that most modern real-world #a(Schema) documents (GitHub, Stripe,
Kubernetes) have moved to 3.1. The 2026-04-18 review also calls out (P2
#15) that `cebe/php-openapi` 1.8.0 (May 2025) still emits 8 PHP 8.4
deprecations from `SpecBaseObject::resolveReferences(): Implicitly
marking parameter $context as nullable`, so the parser question and the
3.1 question were originally entangled.

=== Options considered

#table(
  columns: (auto, 1fr, 1fr),
  [*Option*], [*Pros*], [*Cons*],
  [(a) Swap to `devizzent/cebe-php-openapi`],
  [Active fork; already fixes PHP 8.4 deprecations; claims 3.1 support],
  [Transfers the bus-factor problem to a different maintainer; schema
   validation semantics may differ subtly],

  [(b) Write a 3.1 → 3.0 translator shim],
  [Keeps the well-understood parser; contains the blast radius; easy to
   revert; only the translator is 3.1-aware],
  [Nullable/type-array downgrade loses information; webhooks /
   JSON-Schema-2020-12 features have no 3.0 equivalent],

  [(c) Fork `cebe/php-openapi`],
  [Full control; no upstream deprecation surprises; can add 3.1 at our
   own pace],
  [We own a parser forever; maintenance burden incompatible with a
   single-maintainer project],

  [(d) Defer 3.1 support entirely],
  [Unblocks a credible v0.1 release on the schemas we already support;
   keeps the generator's scope honest; avoids a load-bearing parser
   decision under pre-release pressure],
  [Users with 3.1-only schemas remain blocked until post-v0.1; GitHub /
   Kubernetes validation-tier coverage slips past the first tag],
)

== Choice

Defer OpenAPI 3.1 support to post-v0.1. Ship the first tagged release on
the current `cebe/php-openapi` 3.0 pipeline.

Rationale:

- The review's correctness / coverage P0 and P1 items (hydrator bugs,
  enums, composition, nested inline objects, error responses,
  security) all land on the existing 3.0 pipeline. None of them need
  3.1 to be valuable.
- The 3.1 question is load-bearing — picking (a), (b), or (c) wrong
  costs months. Making that decision under release pressure is worse
  than shipping without it.
- Validation-tier #a(Schema) documents that are 3.1-only (Kubernetes,
  modern GitHub bundles), named in
  #link("schema-fixture-policy.decision-260418.typ")[Schema fixture policy: vendor real-world OpenAPI documents], can be reached via an external 3.1 →
  3.0 pre-processor (e.g. `redocly bundle --ext`) until in-tree support
  lands. This is documented as a known limitation in the README and in
  `truth/notes/openapi-3.1-gap.md`.
- The deprecation-noise problem (P2 #15) is decoupled from 3.1 by this
  decision. The parser-patch task is rescoped to silence the
  deprecations on the current 3.0 parser (composer patch / upstream PR)
  without picking a 3.1 strategy.

== Consequences

- The 3.1-prototype task is withdrawn; `truth/notes/openapi-3.1-gap.md`
  remains as the canonical tracking note and points at this decision.
- The deprecation-silencing task is rescoped to silence cebe's PHP 8.4
  deprecations only; it is no longer a vehicle for the 3.1 decision.
- `ROADMAP.md` lists "OpenAPI 3.1" under explicit post-v0.1 follow-ups.
- The README keeps its "known limitation: OpenAPI 3.1 not yet
  supported" note; no user-facing surprise at release.
- When 3.1 becomes a priority (post-v0.1), this decision is superseded
  by a new decision that picks (a), (b), or (c) with the prototype
  evidence the deferred task was supposed to produce.

=== Alternatives rejected

- *Wait for upstream 3.1 support.* There has been no public movement
  since 2023; indefinite blocking on upstream is not a strategy.
- *Drop poagen's 3.0 support and call 3.1 the baseline.* Inverts the
  same problem and invalidates every schema we ship fixtures for
  today.
- *Silently pick (a), (b), or (c) without the prototype evidence the
  deferred task was meant to collect.* Load-bearing decision without
  the data to back it.

=== Superseded

This decision was superseded on 2026-07-29 by
#link("openapi-31-through-a-maintained-parser.decision-260729.typ")[OpenAPI 3.1 through a maintained parser fork], which picks option (a)
above — swap to `devizzent/cebe-php-openapi` — now that every schema
poagen wants to generate against, including the kilbil loyalty document,
is 3.1-only. The analysis above is a record of what was believed at the
time and is left unchanged.
