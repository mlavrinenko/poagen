#import "@local/mindtape:0.2.0": *

#show: task.with(
  title: "The map-kind round trip in Marshaller and Hydrator has zero test coverage",
  tags: ("quality", "tests", "runtime"),
  priority: 5,
  difficulty: 4,
  status: wip(2026, 8, 2)[milestone: trust the instruments, then use them],
)

== Summary

Filed from triage in `wire-mutation-testing`: infection's mutation run
against `runtime/src/` reported the `PropertyType::KIND_MAP` match arm in
both `Hydrator::decode()` (`runtime/src/Marshal/Hydrator.php:70`) and
`Marshaller::encode()` (`runtime/src/Marshal/Marshaller.php:61`) as
escaped. Checked directly against a raw `phpunit --coverage-clover` run
(not just infection's own classification, which can misattribute coverage
across a multi-line `match` expression): both lines sit at `count=0` —
neither arm executes even once across the entire suite.

`PropertyTypeResolver::resolveArrayLike()`
(`runtime/src/Marshal/PropertyTypeResolver.php:124`-126) produces this
`PropertyType` kind whenever a constructor parameter's phpdoc resolves to
a two-argument generic array shape, `array<KeyType, ValueType>`. No
fixture, example tree, or committed generated model currently has such a
property. Every `array<string, X>` phpdoc shape found in the repository
(`examples/petstore`, `tests/fixtures/generated/petstore`) is an
operation's `@return` type, which goes through the separate
`ResponseType::mapOf()` / `ResponseDecoder` path — not a model property
going through `PropertyTypeResolver` / `Hydrator` / `Marshaller`.

So the first real schema that produces an inline, typed-`additionalProperties`
model property would exercise `decodeMap()` / `encodeMap()` for the first
time in production, with no prior test ever having run either method.

== Acceptance criteria

- A runtime unit test constructs a `PropertyType::mapOf(...)`-typed
  property — directly, or via a fixture class whose constructor-parameter
  phpdoc is `array<string, X>` — and asserts both directions:
  `Marshaller::marshal()` produces the expected wire-shaped map, and
  `Hydrator::hydrate()` recovers the original typed values (not a
  passthrough of raw scalars) from it.
- After the new test lands, `runtime/src/Marshal/Hydrator.php`'s
  `KIND_MAP` arm and `runtime/src/Marshal/Marshaller.php`'s `KIND_MAP` arm
  both show `count` greater than zero in a
  `php -d pcov.directory=. vendor/bin/phpunit --coverage-clover` run.
- Re-running `just mutate` (or a filtered
  `infection run --filter=runtime/src/Marshal/Hydrator.php,runtime/src/Marshal/Marshaller.php`)
  no longer lists the `KIND_MAP` match-arm mutants as escaped.

== Non-goals

- Adding generator support for emitting a real map-shaped model property
  from an OpenAPI schema. That is a separate, larger feature if it does
  not already exist — this task is about testing the runtime primitive
  directly, not about a schema-to-model pipeline.
- Fixing any other escaped mutant found during the same mutation run —
  see `cover-methoddocscanner-token-scan` for the other one filed from
  the same triage pass.
- Re-tuning infection's own coverage or branch attribution for `match`
  expressions.

== Files

- `tests/Unit/Runtime/` — a new or extended test asserting the map round
  trip (e.g. `tests/Unit/Runtime/MarshalRoundTripTest.php`, or a sibling
  file)
- `tests/Unit/Runtime/Fixtures/` — possibly a new fixture class, if a
  phpdoc-driven property is used instead of a direct `PropertyType`
  construction
