#import "@local/speconaut:0.1.0": *
#import "../domain/generation.context.typ": *

#show: decision.with(
  title: "a document-wide timezone is emitted as a constant, never wired into the client",
  status: accepted(2026, 8, 16),
  contexts: (generation-context,),
  goals: (
    link("../goals/user-code-guides-generation.goal.typ"),
    link("../goals/guidance-cannot-mislead.goal.typ"),
  ),
  standards: (link("../standards/guidance-is-data-not-code.standard-260729.typ"),),
)

== Context

`the-consumer-states-the-zone-a-document-left-out` gave a consumer somewhere
to state which zone an offset-free `date-time` means, per client instance,
and deliberately left open where that statement comes from. For a vendor
whose zone varies by installation the construction site is the only honest
home. For a vendor who fixed one zone for every installation it is the wrong
one: every consumer of that client rediscovers the same fact, and a client
package published from the profile carries no trace of it at all.

== Choice

`Profile::$dateTimeZone` states it once, and `Emit\TimezoneConstantEmitter`
puts it on the root client as `public const string NAIVE_TIMEZONE`.

It is a value the consumer reads, not wiring the client applies to itself,
and that is forced rather than chosen: `operations-delegate-to-an-injected-
transport` puts the transport in the consumer's hands before any generated
class exists, so no emitted code is in a position to hand the runtime a
default. `Emit\ServerConstantEmitter` already resolved the identical question
the identical way for the base address, which is the closer precedent than
anything about time.

One constant per tree, not an attribute argument on every date-bearing
property. `generated-duplication-ceiling-is-per-tree` ratchets the emitted
trees, and a zone string repeated across a hundred models is exactly the
shape that moves that number.

The value is checked against PHP's own timezone database before the document
is read, because the failure it prevents is otherwise invisible until run
time in the consumer's application — `DateTimeZone` throws on an unknown
identifier, and a near miss (`Europe/Moskow`, `MSK`, `UTC+3`) reads like a
real zone to whoever typed it. That check joins
`Profile::$responseMaps`'s existing pre-document assertion in
`ProfilePreflight`, which gathers both so a profile wrong in two ways is told
about both rather than about whichever ran first.

== Consequences

Precedence is a matter of composition, not of code: the constant is inert,
so a `BindingContext` built at construction wins by having no competitor.
`README.md` says which of the two homes to pick — installation fact at the
construction site, document fact in the profile — because that is the whole
decision a consumer has to make, and nothing in the type system makes it for
them.

Stating nothing emits nothing, so every golden and example tree in this
repository is byte-identical and no consumer who ignores the field changes
behaviour. That is also why this cannot become a default: poagen has no way
to know a document's zone, and inferring one from an example string is the
silent guess the whole design refuses.
