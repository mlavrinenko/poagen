#import "@local/speconaut:0.1.0": task, done

#show: task.with(
  title: "Hydrate list-typed Model properties by recursing into the declared item type",
  status: done,
  date: datetime(year: 2026, month: 4, day: 18),
  priority: "critical",
  spec: "truth/specs/model-generator.typ",
  decision: "truth/decisions/007-hydration-serialization.typ",
)

== Summary

`ClientEmitter::hydrate()` only recurses when the reflected type is
non-builtin. For a property like `Pet::$tags` (`?array $tags`,
`@param ?list<Tag>`), reflection sees the builtin `array` so the items
are left as raw arrays — breaking the declared phpdoc contract at the
first `$pet->tags[0]->name`.

== Rationale

Pre-release review P0 #1 — release blocker. Petstore's `Pet::$tags`
and every other `list<Model>` property silently violates the
`@phpstan-param` contract today. Until this is fixed, any realistic
schema produces incorrectly-typed data at runtime.

== In scope

+ Extend the #raw("truth/specs/model-generator.typ") "Class emission" rule
  with a scenario: a #raw("list<Model>") property is hydrated as a real
  `list<Model>` (items are instances of the target class).
+ Extend the same rule with a scenario for #raw("list<string>") and
  #raw("list<int>") scalar-list properties — items remain scalars.
+ Teach the emitter to record a per-property item-type directive
  (via the per-Model `PROPERTY_MAP` proposed in ADR-007, or a local
  equivalent) so the hydrator no longer relies on reflection alone.
+ Rewire `ClientEmitter::hydrate()` to consult the directive when a
  property is `array`-typed and recurse into each element.
+ Regenerate the Petstore golden fixture at
  `tests/fixtures/generated/petstore/`.

== Out of scope

- `oneOf` / `anyOf` / `allOf` items (filed separately as task 008).
- Maps (`additionalProperties`) with `$ref` values — cover when
  hydration is extended for the same shape.
- Scalar binding `toScalar()` / `fromScalar()` handling — filed as
  task 004.

== Acceptance

- New scenarios in the Model Generator feature are locked via
  `speconaut lock` by the implementing agent.
- `tests/fixtures/generated/petstore/Generated/Model/Pet.php` hydration
  yields `Tag` instances inside `$pet->tags`, verified by a regression
  test.
- `just check` green end-to-end (library checks + generated-code
  checks, including PHPStan max).
- ADR-007 either confirmed (status flipped to `accepted`) or
  superseded by the task's chosen shape.

== Resolution

Landed together with task 003 (same PROPERTY_MAP work). Highlights:

- `ModelEmitter` now emits `public const array PROPERTY_MAP` on every
  generated Model, pairing each PHP property name with `[wireKey,
  shape]` where `shape` is `null` (scalar), `\FQCN::class` (model
  ref), or `['list', null]` / `['list', \FQCN::class]` (list of
  scalars / models). Each Model also implements `\JsonSerializable`
  and gains an explicit `jsonSerialize()` that returns the array
  keyed by wire names.
- `ClientEmitter::hydrate()` is rewritten to read `PROPERTY_MAP`
  instead of reflecting constructor parameter types. For
  `['list', \FQCN::class]` shapes it `array_map`s each item through
  `self::hydrate(...)`, so `list<Model>` payloads now produce real
  lists of typed objects instead of associative arrays.
- Regression under Model Generator > "Hydration and serialization
  contract (ADR-007)": `A list-of-Model property hydrates each item
  into the declared class` + `A list-of-scalar property hydrates
  items untouched`, both locked. Tests invoke
  `ApiClient::hydrate(Pet::class, …)` via reflection.
- ADR-007 flipped from `proposed` to `accepted`; the chosen shape is
  the `PROPERTY_MAP` variant explicitly listed in the ADR's decision
  §1.
- `tests/fixtures/generated/petstore/*` regenerated.
