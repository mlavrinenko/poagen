#import "@local/speconaut:0.1.0": *

#show: goal.with(
  title: "Real published schemas produce usable clients",
  status: active(2026, 7, 29),
  acid-test: [
    Take a schema as published by a real vendor — not one written to suit
    the generator — and generate against it. Every operation the schema
    declares appears on the client. Every payload shape it declares has a
    type. The result compiles and passes the strict checks. Success is
    measured against the vendor's document as-is, with no hand-editing of
    the schema.
  ],
)

The tempting corpus is the well-formed one: named components, references
everywhere, current specification version, sensible identifiers. Real
vendors publish something else. Payload shapes are written inline and
repeated rather than named and referenced. Identifiers are lowercase runs
with no word boundaries. Format annotations are invented, misspelled, or
contradict the type they annotate. The document targets whichever
specification revision was current when it was written.

Each of those is a normal input, not an edge case, and none of them may
be answered by asking the user to edit the vendor's document. A schema
the user cannot change is the ordinary case, because the user does not
own it — they consume it, and it will be republished next quarter without
consulting them.

Where a document is genuinely ambiguous rather than merely awkward, the
generator asks for guidance and says exactly what it needs. It does not
guess, and it does not quietly emit less.
