#import "@local/speconaut:0.1.0": adr, proposed

#show: adr.with(
  number: 8,
  title: "Strategy for OpenAPI 3.1 support",
  status: proposed,
  date: datetime(year: 2026, month: 4, day: 18),
)

== Context

paogen currently consumes OpenAPI 3.0 via `cebe/php-openapi`. The
pre-release review (P1 #14) and `docs/design/openapi-3.1-gap.md` both
flag that most modern real-world schemas (GitHub, Stripe, Kubernetes)
have moved to 3.1. The 2026-04-18 review also calls out (P2 #15) that
`cebe/php-openapi` 1.8.0 (May 2025) still emits 8 PHP 8.4 deprecations
from `SpecBaseObject::resolveReferences(): Implicitly marking parameter
$context as nullable`, so the parser question and the 3.1 question are
entangled.

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
)

== Decision

*Tentative — awaiting human confirmation. Recommended: (b) translator
shim, with (c) as fallback.*

Reasoning:

- The 3.1 → 3.0 gap is largely a syntactic lowering problem (nullable,
  `type: [a, b]`, `exclusiveMinimum` as a number). A shim that runs
  before the parser keeps paogen's own pipeline untouched.
- The shim is testable in isolation: feed it 3.1 YAML, diff against a
  hand-written 3.0 equivalent, and gate it with a golden-fixture test
  along the lines of ADR-005.
- If the shim proves too lossy for schemas we care about, falling back
  to (c) is mechanical: fork `cebe/php-openapi`, retarget autoload,
  merge the Composer deprecation patch, done.
- (a) is deliberately the *last* preference: we'd be betting that an
  alternative single-maintainer fork outlives the original. The review
  notes `devizzent/cebe-php-openapi` is healthier *right now*, but that
  is not a load-bearing signal.

This ADR stays `proposed` until a task picks one and a working
prototype lands. The shim's feature coverage (nullable, type-arrays,
`webhooks`, `const`, `examples`) is left for the implementing task to
enumerate.

== Consequences

- The 3.1 task (`truth/tasks/015-openapi-31-path-forward.typ`)
  references this ADR and, as part of its acceptance, either confirms
  or supersedes the recommendation with the chosen path.
- If (b) lands, `cebe/php-openapi` stays pinned *and* needs its
  deprecation noise handled separately — see P2 #15 and
  `truth/tasks/016-cebe-php-openapi-replacement.typ`.
- If (c) is chosen, the fork's coordinates are added to
  `composer.json` via a `repositories` entry and this ADR is updated to
  `accepted`.

== Alternatives rejected

- *Wait for upstream 3.1 support.* There has been no public movement
  since 2023; indefinite blocking is worse than any of (a)/(b)/(c).
- *Drop paogen's 3.0-only claim and call it a feature.* Unacceptable:
  ADR-005's validation tier already calls out GitHub and Kubernetes,
  both of which are 3.1-only today.
