#import "@local/mindtape:0.2.0": *

#show: task.with(
  id: "a46c2eb6-be75-410f-b6a2-e1f1e4543acf",
  title: "Generator-time error for `oneOf` without `discriminator` (per attribute-and-phpdoc-driven-serialization)",
  status: done(2026, 4, 20),
  priority: 5,
  x-paogen: (spec: "truth/specs/model-generator.typ", legacy-id: "T-030"),
)

== Summary

`attribute-and-phpdoc-driven-serialization` declares: "`oneOf` / `anyOf` without a discriminator is treated
as a generator-time error; users resolve it either by fixing the spec
or by adding a profile-level discriminator override. Structural
fallback is *not* implemented — silent mis-hydration is worse than a
loud refusal."

T-028 deferred enforcement to keep blast radius small. The runtime
`Hydrator` still falls back to structural matching when the union
descriptor has no `#[Discriminator]`, and the composition fixture
`Animal` (which has no spec discriminator) continues to rely on it.
This task makes the generator refuse such schemas and exposes the
profile escape hatch.

== Scope

+ `CompositionResolver::resolveUnion()` (or the caller in
  `ModelEmitter::applyDiscriminator`): when a `oneOf`/`anyOf` ref
  union has no `discriminator` and no profile override resolves one,
  abort with a typed exception naming the schema, the property,
  and a one-line remediation hint.
+ Add a Profile-level `discriminators` map keyed by
  `'<ComponentName>.<propertyName>' => 'wireField'` so users can
  patch a light spec without forking the YAML. The override fans out
  to a synthesised `discriminator.propertyName` for the runtime.
+ Update the composition fixture: add a `discriminator: { propertyName: petType }`
  to `Animal.creature` (matching `Pet.kind`) so the existing
  structural-match scenario becomes a discriminated one. Or split
  the fixture into a clearly-marked
  `composition-no-discriminator.expected-failure/` example.
+ Drop the structural fallback from `Hydrator::decodeUnion` once the
  generator guarantees every union descriptor carries a
  `#[Discriminator]`.
+ Specs:
  - Add an unstable scenario: "An undiscriminated `oneOf` aborts
    the run with a pointed diagnostic".
  - Add an unstable scenario: "A profile-level discriminator
    override resolves an otherwise-undiscriminated `oneOf`".
  - Update / remove the existing "A `oneOf` of `$ref`-ed components
    becomes a PHP union type" scenario which currently asserts the
    structural-fallback behaviour.

== Non-goals

- `discriminator.mapping` inversion (already handled — map is always
  emitted by the generator).

== Acceptance criteria

- `just check` green with new scenarios locked.
- Removing the discriminator from `Pet.kind` in the composition
  fixture surfaces a generator-time exception whose message names
  `Pet.kind` and the missing field.
- `Hydrator::decodeUnion` no longer contains
  `branchFromStructure()` — the only remaining branch path is the
  attribute-driven one.
