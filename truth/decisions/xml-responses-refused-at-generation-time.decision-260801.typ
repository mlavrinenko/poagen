#import "@local/speconaut:0.1.0": *
#import "../domain/generation.context.typ": *
#import "../domain/schema.context.typ": *

#show: decision.with(
  title: "An application/xml response is refused at generation time, not decoded",
  status: accepted(2026, 8, 1),
  contexts: (generation-context, schema-context),
  goals: (
    link("../goals/fail-loud-never-silent.goal.typ"),
    link("../goals/real-world-schemas.goal.typ"),
  ),
  standards: (link("../standards/silence-means-success.standard-260729.typ"),),
)

== Context

`xml-content-type-policy` closed with two acceptance criteria that
contradict each other once a real `application/xml` response shows up:

+ "An XML request or response reaches a documented, tested outcome rather
  than a silent drop."
+ "XML responses stay unimplemented."

Read separately each sounds reasonable. Read together they cannot both be
true of the same response: "stays unimplemented" meant, in practice, that an
`application/xml`-only 2xx response fell through `OperationAnalyzer` to
`ReturnSpec::void()` — a method that compiles, passes every analysis, and
throws the vendor's body away the moment it is called, with the run exiting
0 and no diagnostic anywhere. That is the silent drop the first criterion
forbids. Nothing in the truth tree recorded which criterion actually
governed, and `default-deny-on-degradation` found this as a live instance of
the general problem it closes.

The corpus settles what is actually at stake: kilbil and petstore carry zero
XML responses between them. This is not a document with real content
paogen needs to decode; it is a hole nobody has hit yet.

== Choice

An `application/xml` 2xx response refuses the operation at generation
time, through the same `SkippedOperation` mechanism every other
unrepresentable construct uses (see `skip-is-the-only-opt-out`). The
generator does not decode XML responses, and does not return the raw body
either.

This decision supersedes the "XML responses stay unimplemented" criterion
from `xml-content-type-policy`. Refusal *is* the implementation: it is a
documented, tested outcome the consumer can act on (accept the operation by
name in `Profile::$skip`, or ask paogen to support it), not the silent void
that criterion's plain reading produced in practice. It satisfies the other,
contradicting criterion — "reaches a documented, tested outcome rather than
a silent drop" — instead of retiring it.

=== Why refuse rather than decode or pass through raw

Two other outcomes were on the table and both cost more than the corpus
currently justifies:

- *Decode to a typed model.* Needs an XML parser dependency paogen does not
  currently have, and a real decision about attributes versus elements that
  `xml-request-bodies-are-serialised-not-refused` explicitly declined to
  make for the response direction — "parsing XML back into a model has
  failure modes serialising out of one does not — inheriting this decision
  would assume the symmetry rather than establish it." That symmetry is
  still unestablished; nothing changed since that decision to establish it.
- *Return the raw body string.* Cheaper, but it is a different consumer
  contract than every other response kind the generator emits — a method
  that sometimes hands back a decoded value and sometimes a wire-format
  string the caller must parse themselves is a surprise `real-world-schemas`
  gives no reason to accept when there is no schema in the corpus asking
  for it.

Refusing costs nothing the corpus needs today and is reversible: the moment
a real schema declares an XML response, `real-world-schemas` is the forcing
function for a follow-up decision on decode-versus-raw, made against an
actual document instead of a hypothetical one.

== Consequences

- `ResponseAnalyzer` (the extraction of `OperationAnalyzer`'s response-side
  logic under `default-deny-on-degradation`) treats "content declared, no
  `application/json` entry" as one uniform refusal regardless of which
  non-JSON content type is present — `application/xml` is not special-cased
  ahead of `text/plain` or anything else undeclared.
- A schema whose only response is `application/xml` fails the run unless
  the consumer accepts it by name in `Profile::$skip`, same as any other
  unrepresentable response.
- The fixture at `tests/fixtures/schemas/response-degradation-3.0.yaml`
  exercises this path so the corpus is no longer silent on it merely
  because no vendor schema in the examples tree happens to declare one.
- Should a vendor schema needing a real XML response arrive, this decision
  is the one to revisit — not `xml-request-bodies-are-serialised-not-refused`,
  which only ever spoke to the request direction.
