#import "@local/mindtape:0.2.0": *

#show: task.with(
  title: "Refined PHPDoc types on generated models from constraints and a profile override",
  tags: (),
  priority: 4,
  difficulty: 3,
  status: proposed(2026, 8, 7),
  links: (related("typed-domain-entity-props.task-260729.typ"),),
)

== Summary

An emitted model property carries the bare PHP type its schema resolves to —
`string`, `int` — even where the document already promised something narrower.
A `minLength: 1` string can never arrive empty; an `integer` whose lower bound
forces a value above zero is never `<= 0`. PHPStan has vocabulary for both
(`non-empty-string`, `positive-int`), and the emitter threw that promise away.

There is also a narrowing OpenAPI cannot express at all. A decimal amount
carried as a JSON string — Kilbil's money fields — is `type: string` in the
document, indistinguishable from free text, yet a consumer wants
`numeric-string`. Nothing in the schema can say so, so it needs a profile
channel the same shape the other property-level overrides already have.

The refinement is a static-analysis fact only. The emitted parameter keeps its
native `string` / `int`, so the runtime, the wire, and every hydration and
marshalling path are byte-for-byte unchanged — only the `@param` on the
promoted constructor parameter (which is how PHPStan narrows a
constructor-promoted readonly property) gets sharper.

== Acceptance criteria

- `Emit\PhpDocTypeRefiner`: pure mapping from (native PHP type, schema,
  override) to a refined PHPDoc type or null. `minLength >= 1` on a string →
  `non-empty-string`; an integer lower bound that forces `> 0` (`minimum >= 1`,
  or a zero-or-above bound made exclusive in either the 3.0 boolean or the 3.1
  numeric spelling) → `positive-int`.
- `Profile::$phpDocTypes`: an override map keyed
  `'<RawComponentName>.<wirePropertyName>'`, mirroring `$propertyRenames`, that
  wins over any constraint-derived reading — chiefly for `numeric-string`.
  Carried through `Profile::with()`.
- `PhpDocTypeValidator`: a stale key (component or property absent from the
  document, or a key with no dot) fails the run in one pass, the same
  stale-guidance refusal `$propertyRenames` carries. Component-property lookup
  shared with `PropertyRenameValidator` through `ComponentPropertyNames`.
- The refined type reaches the emitted model as the promoted constructor
  `@param`, nullable form preserved (`?non-empty-string`), and PHPStan
  pseudo-types are not run through `DocTypeSimplifier::shorten()` (which would
  read them as class names and prefix a stray backslash).
- Plain phpunit unit tests cover the mapping (every branch), the validator, and
  the emitted output. `src/` and `runtime/src/` coverage floors stay green.

== Non-goals

- Does not refine the top-level scalar value object (`ScalarVoEmitter`): its
  `fromScalar()` factory constructs `new self($raw)` from a plain scalar, which
  a narrowed constructor `@param` would make PHPStan reject at max level.
- Does not touch the runtime, the wire format, or any hydration / marshalling
  path — the native type is unchanged.
- Does not regenerate the committed example trees. The refinement changes their
  generated output (github and digitalocean gain `non-empty-string` /
  `positive-int` `@param` lines; petstore and kilbil do not), which is a
  speconaut / `just check-examples` regeneration on the author's machine.

== Files

- `src/Generator/Emit/PhpDocTypeRefiner.php`
- `src/Generator/PhpDocTypeValidator.php`
- `src/Generator/ComponentPropertyNames.php`
- `src/Generator/Emit/ModelEmitter.php`
- `src/Generator/ModelPlanner.php`
- `src/Generator/Generator.php`
- `src/Generator/Profile.php`
- `src/Generator/PropertyRenameValidator.php`
- `tests/Unit/PhpDocTypeRefinerTest.php`
- `tests/Integration/RefinedPhpDocTypeTest.php`
- `tests/Integration/PhpDocTypeValidatorTest.php`
- `tests/fixtures/schemas/refined-types-3.0.yaml`
- `tests/fixtures/schemas/refined-types-optional-3.0.yaml`
