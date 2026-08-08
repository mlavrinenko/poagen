#import "@local/mindtape:0.2.0": *

#show: task.with(
  title: "refine list item types from the item schema constraints",
  tags: ("generator",),
  priority: 4,
  difficulty: 4,
  status: wip(2026, 8, 8)[dispatched to a worktree agent],
  links: (
    related(
      "decide-whether-an-override-may-narrow-a-structural-property.task-260808.typ",
    ),
    related("refined-phpdoc-types.task-260807.typ"),
  ),
)

== Summary

`PhpDocTypeRefiner` narrows a scalar property from what the document already
promised — `minLength: 1` becomes `non-empty-string`, a positive lower bound
becomes `positive-int`. It stops at the property's own node. An array property
whose `items` carry the identical constraints still emits a bare
`list<string>`: the refiner is only consulted where the resolver left the
structural slot empty, and for a list it never is.

That gap is what makes `'Order.tags' => 'list<non-empty-string>'` look like a
missing profile channel. It is not — the document says it already, in the place
poagen prefers to read shapes from
(`declared-shapes-become-types`). Reading it there needs no new profile key, no
verbatim structural string nobody checked, and no compatibility question: the
native type stays `array`, and `list<non-empty-string>` is a strict subtype of
the `list<string>` the emitter would otherwise print.

One hazard is already documented and has to be handled rather than
discovered: `PropertyDocType` runs a structural doc type through
`DocTypeSimplifier::shorten()`, which resolves class references against the
namespace. A PHPStan pseudo-type inside that structural type is not a class,
and shortening one today prefixes a stray leading backslash — the exact reason
scalar pseudo-types bypass `shorten()` entirely. `list<non-empty-string>` puts
a pseudo-type inside the structural slot for the first time, so the shortener
has to learn the difference.

== Acceptance criteria

- An array property whose `items` declare `minLength: 1` emits
  `list<non-empty-string>`, and one whose `items` declare a positive lower
  bound emits `list<positive-int>`, from the document alone with no profile
  entry.
- `DocTypeSimplifier::shorten()` leaves a known PHPStan pseudo-type inside a
  structural type alone and still shortens a class reference beside it, proven
  by a test over a type carrying both.
- Items that narrow nothing emit exactly what they emit today, byte for byte,
  across every golden fixture.
- A golden fixture carries the refined list form and passes
  `lint-phpstan-generated` at max level, so the consumer view is proved rather
  than asserted.
- Nested items (a list of lists, a map of lists) either refine consistently or
  are left alone with the reason recorded in the refiner.

== Non-goals

- Does not widen `Profile::$phpDocTypes` to structural values. That question is
  settled by `decide-whether-an-override-may-narrow-a-structural-property`, and
  this task is the answer it points at.
- Does not derive `array{...}` shapes from an object schema. A list's item type
  is one step; a whole shape language is not.
- Does not touch the emitted native types or the runtime.

== Files

- `src/Generator/Emit/PhpDocTypeRefiner.php`
- `src/Generator/Emit/PropertyDocType.php`
- `src/Generator/Emit/DocTypeSimplifier.php`
- `tests/fixtures/generated/refined-types/`
