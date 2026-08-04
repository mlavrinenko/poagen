#import "@local/speconaut:0.1.0": *
#import "../domain/generation.context.typ": *
#import "../domain/schema.context.typ": *
#import "../domain/guidance.context.typ": *

#show: decision.with(
  title: "A payload-level result envelope stays the consumer's business",
  status: accepted(2026, 8, 4),
  contexts: (generation-context, schema-context, guidance-context),
  goals: (
    link("../goals/real-world-schemas.goal.typ"),
    link("../goals/fail-loud-never-silent.goal.typ"),
    link("../goals/guidance-cannot-mislead.goal.typ"),
  ),
  standards: (
    link("../standards/silence-means-success.standard-260729.typ"),
    link("../standards/caller-surface-is-injectable.standard-260729.typ"),
  ),
)

== Context

kilbil's vendor document declares two responses on every operation, `200`
and `403`, and #the(Generator) already treats that boundary correctly: a
`403` throws `ApiException`, and a `200` hydrates into its declared #a(Model)
either way. What the document does not declare is that inside that `200`
body, one property carries a second, vendor-specific verdict. `result_code`
is `type: string` on all 36 operations; `'0'` means the call succeeded and
every other value means it did not, and OpenAPI has no construct for saying
so. #The(Generator) emits the field faithfully — the shape is exactly what
#the(Schema) says — and stops there, because #the(Schema) stops there too.

Payload-level status is not a kilbil idiosyncrasy. It is a known shape in
older and loosely-REST vendor APIs that predate consistent use of HTTP
status codes. Wherever it appears, the property carrying it and the values
that count as success are vendor knowledge no OpenAPI construct records —
`real-world-schemas` names exactly this kind of document as the ordinary
case, not the edge case, and says #the(Generator) must not guess at what the
document does not say.

A caller who checks nothing gets a response object that hydrated cleanly,
typed exactly as declared, and is wrong. That is not a defect
`silence-means-success` catches: the standard measures success by whether
every payload shape #the(Schema) declares reached the emitted tree, and
`result_code` does — present, typed `string`, exactly as declared. Nothing
was dropped, so the standard's job is done; it never asked whether the
values inside a present field mean what the vendor thinks they mean.
`fail-loud-never-silent` is aimed at the neighboring question and stops at
the same line: its acid test is a schema #the(Generator) cannot represent,
and `result_code` is represented completely. Both goals draw their boundary
at generation time. The failure this decision is about happens after
generation, at the call site, and neither goal's door opens onto it.

The gap is real, and the kilbil example already closes it for the two
operations that need it: a hand-written `PhoneConfirmation` wrapper adds
`isCodeValid`, which reads `result_code` and returns a bool, without
#the(Generator) knowing anything happened. The question this decision
answers is whether that stays the whole answer, or whether #a(Profile) grows
a way to declare the envelope so #the(Generator) can do something with it.
Three shapes were on the table.

- *Leave it to consumer wrappers, as today.* #the(Generator) hydrates
  `result_code` like any other declared string property. A consumer who
  cares writes the check themselves, the way `PhoneConfirmation` already
  does. Nothing new ships; the cost is that every consumer of every
  envelope-shaped vendor document pays the same small tax, once per
  operation that matters to them.
- *Declare the envelope in #a(Profile); #the(Generator) throws.* A new
  guidance surface names the status property and its success values, once
  per operation or once per document. #The(Generator) reads the hydrated
  body, checks the named property, and throws `ApiException` — the same
  exception a non-2xx status already throws — when the value is not a
  declared success. A caller stops having to remember to check.
- *Declare it; #the(Generator) exposes a typed predicate, no throw.* Same
  new guidance surface, but #the(Generator) emits a method such as
  `isSuccess(): bool` on #the([response], Model) instead of throwing. A
  caller still has to call it, but the check is generated rather than
  hand-written, and a `200` never becomes an exception.

== Choice

The first option: leave it to consumer wrappers. #The(Generator) grows no
new #a(Profile) surface for a payload-level envelope, and does nothing with
one when a document has it.

Not because it is cheapest to build, though it is. The other two share a
defect the first does not, and that defect — not cost — is why this needed
a decision rather than the task simply taking the more capable-looking
option.

=== Why a generator answer is worse

Both of the rejected options need #a(Profile) entry naming which property
is the status and which values count as success. That entry cannot be
checked the way every other form of guidance is. `guidance-cannot-mislead`
requires every #a(Profile) claim to be verified against #the(Schema) before
it is used — a rename is checked against a name #the(Schema) declares, a
bound format is checked against a format string #the(Schema) uses. A
status-envelope entry has nothing to check against beyond the property's
existence: OpenAPI carries no vocabulary for "this value means success", so
#the(Schema) can confirm `result_code` exists and is a `string`, and can
confirm nothing about what `'0'` means. The claim is unfalsifiable by
construction, not merely unverified today — there is no document state that
would make it wrong in a way #the(Generator) could detect.

That turns a wrong guess into a worse failure than the one being fixed.
Today's failure is silent: a caller who checks nothing gets a
wrong-looking-right answer. A generator that throws on a mistaken guess is
loud in the wrong direction — it takes an operation that worked, on a
document read correctly in every other respect, and turns it into a thrown
`ApiException`, indistinguishable at the call site from the `403` case it
already handles. The predicate option softens that particular blow — nothing
throws — but the predicate itself still asserts a vendor-specific meaning
#the(Generator) cannot verify, so a wrong `isSuccess()` is a typed method
lying with a compiler's confidence behind it, which is a worse kind of wrong
than a string property a consumer already knows to be suspicious of.

=== What would reopen this

The load-bearing fact is that the vendor's document never marks the
property. If OpenAPI itself, or a vendor-neutral extension convention
vendors actually populate, starts declaring which property carries
payload-level status and what its success values are, the claim moves from
vendor knowledge to schema-derived fact — checkable the way a rename or a
bound format is checked today — and the two rejected options are worth
reopening on that basis. Nothing short of that changes the answer. A second
or third vendored document with the same shape as kilbil's is more evidence
the problem is common; it is not evidence that it becomes checkable.

== Consequences

- #The(Generator) grows no new #a(Profile) field for this. `result_code`,
  and anything shaped like it in a future vendored document, hydrates like
  any other declared string property, and stays that way after this
  decision.
- `error-response-policy`'s `ApiException` is unaffected: it still fires on
  a non-2xx status alone, and this decision adds no second trigger inside a
  `200` body. `typed-error-responses` stays a separate question for the same
  reason — it is about schemas the document marks as error responses, and a
  payload-level envelope is a response the document marks as success.
- The pattern that answers this for a consumer is already built and proven,
  not merely proposed. `caller-surface-is-injectable` is why it costs as
  little as it does: `PhoneConfirmation` reaches the generated
  implementation through an interface's constructor injection, so the
  wrapper is compiler-checked against that interface and survives
  regeneration without touching anything generated.
- `examples/kilbil/README.md` owes a line at the point a reader meets
  `result_code`, pointing at that wrapper — the artifact a future reader of
  the example needs, so they meet the answer where they meet the question.
- Any vendor document with the same envelope shape pays the same cost
  kilbil's does: a caller who checks nothing gets a wrong-looking-right
  answer, and a caller who cares writes a wrapper. That cost is now a
  recorded decision rather than an unrecorded gap.
