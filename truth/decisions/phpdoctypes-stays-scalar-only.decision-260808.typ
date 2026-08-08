#import "@local/speconaut:0.1.0": *
#import "../domain/generation.context.typ": *
#import "../domain/guidance.context.typ": *
#import "../domain/schema.context.typ": *

#show: decision.with(
  title: "Profile::$phpDocTypes stays scalar-only, and gains no structural key",
  status: accepted(2026, 8, 8),
  contexts: (generation-context, guidance-context, schema-context),
  goals: (
    link("../goals/declared-shapes-become-types.goal.typ"),
    link("../goals/guidance-cannot-mislead.goal.typ"),
  ),
  standards: (
    link("../standards/analysis-runs-at-maximum-strictness.standard-260729.typ"),
  ),
)

== Context

`refuse-a-phpdoctypes-override-the-property-cannot-carry` made an override
on a property the resolver already gave a structural PHPDoc — `list<Tag>`,
`array<string, mixed>` — fail the run instead of being silently dropped.
Refusing is honest where the old silent drop was not: `Emit\PhpDocTypeCompatibility::reject()`
now names the entry and the structural type it would have had to displace.

Refusing is not the same as answering. `'Order.tags' => 'list<non-empty-string>'`
is a narrowing a consumer might legitimately want, and the refusal leaves no
way to spell it — the channel only ever reaches a property whose PHPDoc slot
the resolver left empty. `decide-whether-an-override-may-narrow-a-structural-property`
asked whether that should change: widen the channel to accept a structural
override on trust, leave it refused, or open a second, structural-shaped key
with its own rules. This records the answer.

== Choice

#a(Profile)'s `$phpDocTypes` stays scalar-only. The channel does not widen to
carry a structural override, and it does not gain a second key for one.

=== What a structural override would cost the emitter

A scalar override is a closed vocabulary — a fixed table of PHPStan
pseudo-types, checked once and printed verbatim. A structural override would
not be: `list<Tag>`, `array{a: int, b: string}`, and whatever a consumer
writes next are an open grammar, not a table. `DocTypeSimplifier::shorten()`
already draws the line this would have to cross both ways at once. A
structural type carries class references, so it has to go through
`shorten()` to print short against the namespace; a scalar pseudo-type must
never go through it, because `shorten()` then reads the pseudo-type as a
class name and prefixes a stray leading backslash — see `PropertyDocType`'s
own docblock. A structural override sits on both sides: it would need
shortening for the class references inside it and protection from shortening
for the pseudo-types beside them, so the emitter would have to know which
kind of thing it was holding, member by member. The one mechanism
`PhpDocTypeCompatibility` has today — refuse by name from a closed
vocabulary — answers "is this string one of a fixed set" and has no answer
to "is this well-formed member of an open grammar," which is a different and
harder question.

=== Compatibility is not equally checkable

Even granting the parsing problem solved, what the emitted PHPDoc has to
stay true to is the checkable question, and it is not one question.
`list<T>` over a native `array` is checkable — a list is a list regardless
of `T`. `array{a: int}` over `array` is weaker: nothing enforces that the
override's keys are the ones the schema actually declares. Whatever a
consumer types after that is undecidable in general. An override poagen
accepted on trust and PHPStan then rejected inside the consumer's own
analysis of code they did not write is exactly the failure
`refuse-a-phpdoctypes-override-the-property-cannot-carry` was written to
stop — widening the channel to a shape poagen cannot fully check would
reopen it one level up, for structural types instead of scalar ones.
`analysis-runs-at-maximum-strictness` is explicit about whose job that
checking is: the emitted tree is analysed exactly as a consumer's own code
would be, at max level, with nothing suppressed, and a finding there is
fixed at its source rather than annotated away — never exported into the
consumer's own repository as their problem to baseline. An override channel
that cannot itself decide whether the type it prints survives that analysis
would be exporting exactly the unfinished checking work that standard says
does not leave poagen.

=== The narrowing wanted is already in the document

`'Order.tags' => 'list<non-empty-string>'` is not missing from what the
vendor wrote — `items: {type: string, minLength: 1}` already says it. It is
missing from the reader: `PhpDocTypeRefiner::refine()` only ever looks at the
property's own #the(Schema) node, so an array property whose `items` carry
the identical constraints the refiner already understands for a scalar
property still emits a bare `list<string>`. Teaching `PhpDocTypeRefiner` to
look one level into `items` needs no new channel, no override to trust, and
no compatibility question at all: the native type stays `array`, and
`list<non-empty-string>` is a strict subtype of what would otherwise be
printed, the same relationship every constraint-derived narrowing already
carries. That work is filed as
`refine-list-item-types-from-the-item-schema-constraints`, and this decision
names it as where the legitimate want behind this question is actually
served — not by a wider `$phpDocTypes`, by reading one more level of a
document poagen already reads. That task also carries its own hazard,
recorded there rather than here: `DocTypeSimplifier::shorten()` has to learn
to leave a known pseudo-type sitting inside a structural type alone once a
structural doc type can contain one for the first time. That is a real
instance of the "which kind of thing is this" problem the first section
above describes — but scoped to one place `shorten()` already runs,
reachable by widening what it recognises, not by adding a second trust
channel with its own compatibility question. It is that task's problem to
solve, not this one's.

=== What stays illegal

Restated here so the next reader does not have to re-derive it from the
code: any `$phpDocTypes` value that is not a name in
`PhpDocTypeCompatibility`'s scalar vocabulary; any value on a property the
resolver already gave a structural PHPDoc; any value on a class-typed or
untyped property; a `?T` or `T|null` respelling nullability the schema
already decides; a union spanning two native types. All five are refused
today and none of them are reopened by this decision — it settles the one
question `decide-whether-an-override-may-narrow-a-structural-property`
raised, which is the second item on this list, and leaves the other four
exactly where `refuse-a-phpdoctypes-override-the-property-cannot-carry` put
them.

=== What would reopen this

A concrete narrowing a consumer legitimately wants, that the document
genuinely cannot express, and that is not derivable from any constraint
already declared on the schema. A hypothetical is not that — `list<non-empty-string>`
itself was the candidate on the table for this decision, and it fails the
test on its third clause: it is derivable, from `items.minLength`, by
`refine-list-item-types-from-the-item-schema-constraints`. Reopening this
would need a case where reading the document harder does not get there.

== Consequences

- `PhpDocTypeCompatibility::reject()`'s structural-case refusal now names
  this decision by slug, so a consumer who hits it lands on the answer
  instead of re-deriving it from first principles. `tests/Unit/PhpDocTypeCompatibilityTest.php`
  and `tests/Integration/RefinedPhpDocTypeTest.php` assert the pointer is
  present, not merely that the refusal still fires.
- The other four refusals `PhpDocTypeCompatibility` raises — vocabulary,
  non-scalar native type, cross-type union, respelled nullability — are
  untouched by this decision and do not name it; naming a decision that did
  not decide them would send the next reader to the wrong artifact.
- `refine-list-item-types-from-the-item-schema-constraints` remains
  `proposed`, unaffected in scope by this decision beyond being the answer
  it points at. Landing it changes what `list<T>` properties emit; it does
  not touch `$phpDocTypes` or anything this decision governs.
- The non-goals `decide-whether-an-override-may-narrow-a-structural-property`
  already named stand: the scalar refusals are not revisited, and no channel
  opens for operation parameters or synthesised models.
