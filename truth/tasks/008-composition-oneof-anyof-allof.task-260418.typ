#import "@local/mindtape:0.2.0": *

#show: task.with(
  id: "879ae91f-d8dc-4661-a16b-5d91d1f00ab8",
  title: "Emit typed PHP for oneOf / anyOf / allOf composition",
  status: done(2026, 4, 18),
  priority: 7,
  x-paogen: (spec: "truth/specs/model-generator.typ", legacy-id: "T-008"),
)

== Summary

`TypeResolver::resolve()` today has no branch for `oneOf`, `anyOf`, or
`allOf`; they fall through to the `default` and become `mixed` in both
PHP types and PHPStan annotations. Every non-trivial real API uses
composition, so this is a coverage-blocking gap.

== Rationale

Pre-release review P1 #7 — coverage gap. Without composition, any
schema that models alternatives (Stripe, GitHub) loses its structure at
the generator boundary.

== In scope

+ Add scenarios under the Model Generator for each composition
  keyword:
  - `oneOf` of two `$ref`-ed components → PHP union type (e.g.
    `Dog|Cat`), with a `@phpstan-return` that mirrors the union.
  - `anyOf` of the same shape → identical treatment for the first
    cut; leave true intersection semantics for a follow-up.
  - `allOf` that merges two object schemas → emit a single Model
    whose promoted properties are the union of both (conflicts
    resolved by the later entry winning, matching cebe parser
    semantics).
+ Extend `TypeResolver::resolve()` accordingly; extract a
  `CompositionResolver` helper if the single class grows past the
  linecop limit.
+ Cover the hydrator for `oneOf`: discriminate by structure (keys
  present) when no `discriminator` is declared; honour
  `discriminator.propertyName` when it is.
+ Regenerate any golden fixtures that benefit from composition
  coverage.

== Non-goals

- `discriminator.mapping` inversion (mapping → class). Start with
  `propertyName` only; add mapping when a fixture needs it.
- `not` keyword — rarely used in practice; file follow-up if a
  real schema surfaces it.
- Recursive composition (Model A `oneOf` [Model B, Model A]) — note
  in the scenario's out-of-scope if it proves intractable.

== Acceptance criteria

- Each composition keyword has at least one locked scenario in the
  Model Generator feature.
- A new fixture schema (or the Petstore schema extended) exercises
  `oneOf` with a `discriminator`, and its golden output is
  committed.
- `just check` green end-to-end.
