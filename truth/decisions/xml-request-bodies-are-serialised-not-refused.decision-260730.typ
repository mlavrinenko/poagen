#import "@local/speconaut:0.1.0": *
#import "../domain/schema.context.typ": *
#import "../domain/guidance.context.typ": *
#import "../domain/generation.context.typ": *

#show: decision.with(
  title: "An XML request body is serialised, and its element names come from the profile",
  status: accepted(2026, 7, 30),
  contexts: (generation-context,),
  goals: (
    link("../goals/real-world-schemas.goal.typ"),
    link("../goals/fail-loud-never-silent.goal.typ"),
  ),
  standards: (
    link("../standards/silence-means-success.standard-260729.typ"),
    link("../standards/guidance-is-data-not-code.standard-260729.typ"),
  ),
)

== Context

#A(Schema) may declare a request body as `application/xml`. #The(Generator)
understood JSON and form-encoded bodies, stubbed multipart and octet-stream, and
had no story at all for XML — so an XML body fell into the silent-skip path that
`fail-loud-never-silent` forbids.

== Choice

XML request bodies are serialised. The element names #the(Schema) does not supply
come from #a(Profile), and their absence stops the run.

=== Why not refuse

Refusing was the cheaper answer and it was wrong here.

The schema is fully declared. `goodsxml` and `goodslistxml` in the kilbil loyalty
document carry the same inline object schemas as their JSON twins `goods` and
`goodslist`, and their description says outright that the XML mirrors the JSON
structure. Nothing about the payload is unknown; only the serialisation is
different, and it is a serialisation #the(Generator) can do. Refusing would have
cost two of thirty-six operations over the last step of a pipeline that already
had every earlier step.

It would also have made `real-world-schemas` untrue in the specific way that goal
was written against. Every response in that document is JSON, so XML is
request-only and bounded — two operations, one direction, no content negotiation
on the way back. A generator that gave up on a bounded, declared, one-directional
case is a generator whose corpus is the well-formed one after all.

=== Why the element names are a question and not a default

OpenAPI names elements for properties: a property becomes an element of the same
name, and an array is unwrapped unless `xml.wrapped` says otherwise. It names
nothing for the document root, and nothing for the repeated element of a body
whose schema is a bare array. The kilbil document carries no `xml:` metadata at
all, so both are genuinely undetermined rather than merely awkward.

That is the distinction `real-world-schemas` draws, and it lands on asking:
#the(Generator) reports what it needs rather than guessing. A guessed root element
does not fail visibly — it produces well-formed XML the vendor's parser rejects,
which surfaces as a 400 at runtime against a live endpoint. Asking at generation
time costs one line in #a(Profile).

So `Profile::$xmlElements` names the root, and the repeated element for a list
body, keyed on the raw operation id. An XML body with no entry is reported as
unrepresentable and can be accepted by name in `Profile::$skip` like any other —
one of the reactions already recognised, not a fourth.

== Consequences

Serialisation runs *after* the marshalling step rather than instead of it. Wire names, scalar bindings and date formats are decided once
for both content types, so JSON and XML cannot disagree about a value. Only the
final encoding differs.

An operation offering both JSON and XML prefers JSON silently. There is nothing
to warn about: the payload is the same and the consumer gains nothing from the
XML path.

XML *responses* are out of scope and remain unimplemented, because the corpus
contains none. Should one appear, it needs its own decision — parsing XML back
into #a(Model) has failure modes serialising out of one does not, and inheriting
this decision would be assuming the symmetry rather than establishing it.
