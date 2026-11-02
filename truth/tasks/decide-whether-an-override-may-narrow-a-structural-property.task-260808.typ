#import "@local/mindtape:0.2.0": *

#show: task.with(
  title: "Decide whether an override may narrow a structural property",
  tags: (),
  priority: 3,
  difficulty: 6,
  status: done(
    2026,
    8,
    8,
  )[ruled scalar-only; decision phpdoctypes-stays-scalar-only, refusal points at it],
  links: related(
    "refuse-a-phpdoctypes-override-the-property-cannot-carry.task-260808.typ",
  )[that task implements the refusal this decision asks for],
)

== Summary

`Profile::$phpDocTypes` on a property the resolver already gave a structural
PHPDoc now fails the run: the override cannot displace `list<string>`, so
refusing it is honest where the old silent drop was not. Refusing is not the
same as answering, though — `'Order.tags' => 'list<non-empty-string>'` is a
narrowing a consumer might legitimately want, and today there is no way to
spell it.

Letting the override win is not a one-line change. A structural type carries
class references, so it would have to go through
`DocTypeSimplifier::shorten()` — which is exactly what a scalar pseudo-type
must not go through — and the emitter would then need to know which kind it
holds. It also reopens the compatibility question at a harder level: `list<T>`
over a native `array` is checkable, `array{a: int}` over `array` less so, and
whatever passes has to stay PHPStan-legal against the emitted native type.

Decide whether the channel widens, stays scalar-only, or gains a separate
structural-override key with its own rules.

== Acceptance criteria

- A decision artifact under `truth/decisions/` records the answer and why, in
  the terms above: what a consumer can spell, what poagen checks, and which
  emitted forms stay illegal.
- If the channel widens, the refusal in `Emit\PhpDocTypeCompatibility` is
  replaced by the checked path, not merely dropped, and a golden fixture puts
  the widened form in front of `lint-phpstan-generated`.
- If it stays scalar-only, the refusal message points at the decision so the
  next reader does not re-derive it.

== Non-goals

- Does not revisit the scalar refusals, which stand either way — a base type
  the native one contradicts is broken output, not a missing feature.
- Does not add a channel for operation parameters or synthesised models.

== Files

- `truth/decisions/` — a new decision artifact
- `src/Generator/Emit/PhpDocTypeCompatibility.php`
- `src/Generator/Emit/PropertyDocType.php`
