#import "@local/speconaut:0.1.0": *

#show: goal.with(
  title: "A shape the document declares becomes a type, never a bag",
  status: active(2026, 8, 2),
  acid-test: [
    Generate against a document in which every payload is described, and
    read the emitted tree. No property, parameter or return value is typed
    `mixed`, and none is a bare `array` standing in for an object the
    document described. Where the document declared several possible
    shapes, the emitted type names all of them. Where the document
    genuinely declared nothing, the type says so and the run reports the
    field, so an unconstrained value is visible rather than merely
    tolerated.
  ],
)

A generator that answers a declared structure with an array has stopped
generating a client. The consumer came for the schema's knowledge expressed
as code; handing back the decoded payload gives them the parsing job they
already had, minus the schema they could have read themselves.

So a declared shape becomes a class. A declared choice between shapes
becomes a union of classes. A declared list becomes a typed list, and a
declared string-keyed map becomes a typed map — those two are collections,
not evasions, and a PHP array is what a collection is.

The pressure this goal exists to resist is the one that arrives when a
construct is awkward. Every widening starts as a local decision about one
difficult schema, and each one is individually defensible: nobody sets out
to emit `mixed`. What makes them add up is that a widened type costs the
generator nothing and costs every consumer forever, and that the consumer
is not in the room when the choice is made.

Where the generator genuinely cannot express what the document declared,
the answer is the one `fail-loud-never-silent` already gives: stop and say
what would make it acceptable. Refusing is honest and a `mixed` is not,
because a refusal can be argued with and a `mixed` is discovered in
production.

The exception is real and narrow. A vendor who writes a property with no
type, no properties and no items has declared nothing, and `mixed` is then
the truthful type rather than a widening — the generator is reporting the
document's silence, not adding its own. That case is reported on the run so
the consumer can see where their vendor said nothing, and it is the only
shape of it.
