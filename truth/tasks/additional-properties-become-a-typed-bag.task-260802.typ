#import "@local/mindtape:0.2.0": *

#show: task.with(
  title: "A schema that declares additional properties carries them, in a runtime bag",
  tags: ("generator", "runtime", "dx"),
  priority: 6,
  difficulty: 5,
  status: accepted(2026, 8, 2),
)

== Summary

A schema that declares `properties` and also allows extra ones today emits the
declared properties and discards the extras — or, at payload granularity,
discards the declared ones instead and emits a bare map. Both directions lose
something the document described.

The owner's ruling on 2026-08-02: a schema that explicitly allows extras gets a
promoted property carrying them, typed by a runtime class rather than a bare
array, so a consumer reaching for an undeclared field has an object with a
method rather than an array they have to guard.

One boundary is this task's own decision, and it matters more than the rest:
`additionalProperties` omitted is not the same as `additionalProperties: true`.
JSON Schema defaults the keyword to `true`, so treating omission as an explicit
allowance would put a bag on every model paogen has ever emitted — 107 of them
in kilbil alone, none of them asked for. An author who wrote nothing said
nothing. So the bag appears only where the document says `true`, or gives a
schema for the extra values.

The practical value is a vendor adding a field next quarter: a consumer on a
schema that allows extras reads the new field the day it ships, instead of
regenerating and hoping.

=== One criterion landed early, 2026-08-02

`close-the-three-sites-that-widen-a-declared-shape` implemented the third
criterion below — a schema-valued `additionalProperties` alongside declared
`properties` now emits both, at property and payload granularity, rather than
discarding one half. It could not honestly stop short of that: it emitted the
typed map property, so something had to fill it. `AdditionalPropertyEmitter`
appends the property, `#[AdditionalProperties]` marks it, and `Hydrator` and
`Marshaller` carry the extras in both directions.

So the criterion stays in the list and stays checkable, but it is already
satisfied. What remains for this task is the `true` case: the runtime bag
class, which hangs off the mechanism that already exists rather than
introducing a second one. Reuse `#[AdditionalProperties]`; do not add a
sibling attribute for the untyped variant.

== Acceptance criteria

- `additionalProperties: true` on a schema with declared properties emits those
  properties as typed properties plus one more, carrying the undeclared keys in
  a runtime class the runtime package owns.
- That class is a real object, not an array alias: it answers whether a key is
  present, returns a value by key, lists its keys, counts, and iterates. It is
  immutable, like every other emitted value.
- `additionalProperties` given as a schema emits a typed map of that schema's
  type, as it does today, and the declared properties are kept alongside it
  rather than discarded.
- `additionalProperties` omitted changes nothing. No bag, no new property, and
  every existing emitted class is byte-identical after this task.
- `additionalProperties: false` changes nothing either, and stays the signal
  that closes a shape — the union work depends on that meaning.
- Marshalling round-trips: a value hydrated from a payload with extra keys and
  marshalled back carries those keys, unchanged and in a stable order.
- The bag never shadows a declared property. A payload key matching a declared
  property goes to that property, never into the bag as well.

== Non-goals

- Making omission mean `true`. Argued above; it would rewrite every model in
  every example for a permission nobody granted.
- Validating extra values against anything. Where the document gives a schema
  for them they are typed; where it says `true` they are whatever arrived.
- Deriving a class from the extras. There is no shape to derive.

== Files

- `runtime/src/` (a new value class)
- `src/Generator/Emit/InlineObjectResolver.php`
- `src/Generator/Emit/ModelEmitter.php`
- `src/Generator/Emit/PropertySynthesiser.php`
- `runtime/src/Marshal/Hydrator.php`, `runtime/src/Marshal/Marshaller.php`
- `tests/`
