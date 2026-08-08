#import "@local/mindtape:0.2.0": *

#show: task.with(
  title: "Refuse a phpDocTypes override the property cannot carry",
  tags: (),
  priority: 6,
  difficulty: 4,
  status: done(
    2026,
    8,
    8,
  )[Refusals proven end to end; full gate green on the merged tree],
  links: (related("refined-phpdoc-types.task-260807.typ"),),
)

== Summary

`PhpDocTypeValidator` checks only that an override's key still resolves — the
component exists, the property exists. It never asks whether the property can
carry the type the override names, and both ways that goes wrong are silent.

An override on a property whose native type is not the override's base type is
emitted anyway: `'LineItem.quantity' => 'numeric-string'` over `public int
$quantity` prints `@param numeric-string $quantity`, and PHPStan at max rejects
the generated file — `PHPDoc tag @param for parameter $quantity with type
string is incompatible with native type int`. The poagen run itself succeeds,
so the breakage surfaces one tool later, in the consumer's own analysis of code
they did not write. The same happens over a class-typed property (a `$ref` to a
scalar component resolves to a value object, not `string`).

An override on a structural property is dropped without a word: the refiner is
consulted only where the resolver left no PHPDoc, so `list<string>` keeps the
slot and the override never applies. That is exactly the stale-guidance failure
the validator's own docblock says it exists to prevent — guidance that reads as
working and silently does nothing.

== Acceptance criteria

- An override whose base type differs from the property's resolved native type
  fails the run, in the one-pass `UnrepresentableConstructsException` the other
  profile validators use, naming the key, the override, and the native type.
- An override on a property the resolver already gave a structural PHPDoc
  (`list<Tag>`, `array<string, mixed>`) fails the run naming the key and the
  structural type it would have to displace, rather than being dropped.
- An override poagen does not recognise as a scalar PHPDoc type fails the run
  naming what is recognised. Recognised: the PHPStan string / int / float /
  bool pseudo-types, an `int<a, b>` range, quoted string literals, integer and
  float literals, and a `|` union whose members share one base type.
- An explicit `|null` member fails with its own message: nullability comes from
  the schema and the emitter adds it, so writing it again widens the PHPDoc
  past the native type.
- Every existing valid override keeps working — `numeric-string` on a `string`
  property, the constraint-derived narrowings, the committed example trees, and
  the generated-tier PHPStan config stay green.
- Unit tests cover the compatibility mapping branch by branch; an integration
  test proves each refusal end to end and that a generated tree with a valid
  override still passes PHPStan at max.

== Non-goals

- Does not make an override win over a structural PHPDoc. Whether
  `list<non-empty-string>` should be spellable is a separate question; this task
  only stops the silent drop.
- Does not extend the channel to `mixed` properties, to operation parameters, or
  to synthesised (inline) models — the key shape stays
  `'<RawComponentName>.<wirePropertyName>'`.
- Does not resolve `$ref` nodes for constraint-derived narrowing.
- Does not change any emitted output for a profile that is already valid.

== Files

- `src/Generator/Emit/PhpDocTypeCompatibility.php`
- `src/Generator/Emit/ModelEmitter.php`
- `src/Generator/Emit/ModelEmission.php`
- `src/Generator/Emit/DocTypeSimplifier.php`
- `src/Generator/ModelPlanner.php`
- `src/Generator/Generator.php`
- `src/Generator/Profile.php`
- `tests/Unit/PhpDocTypeCompatibilityTest.php`
- `tests/Integration/RefinedPhpDocTypeTest.php`
- `tests/fixtures/schemas/refined-types-3.0.yaml`
