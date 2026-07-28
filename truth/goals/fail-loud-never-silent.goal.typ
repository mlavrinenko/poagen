#import "@local/speconaut:0.1.0": *

#show: goal.with(
  title: "Anything the generator cannot represent stops the run",
  status: active(2026, 7, 29),
  acid-test: [
    Feed the generator a schema containing a construct it does not
    support. It reports a non-zero result, names the construct and where
    in the schema it appeared, and writes nothing. There is no
    configuration under which an unrepresentable construct becomes an
    omitted method, an omitted model, or a permissive type, while the run
    still reports success.
  ],
)

The worst failure a generator can have is a quiet one. A dropped
operation looks exactly like an operation the schema never declared, and
the consumer discovers the difference in production, months later, when
they go looking for a method that was never emitted.

So the default is refusal. Every construct is either understood and
emitted, or it stops the run with a message that names the schema
location and states what would make it acceptable. Success means the
whole schema was represented.

A user may knowingly relax this for a schema they do not control, but
relaxation is explicit, scoped to the constructs they named, and recorded
in their guidance where the next reader will find it. It is never the
default and it is never implied by silence.

The same discipline applies uniformly. Two constructs the generator
cannot represent must fail the same way; a generator that aborts on one
and shrugs at another has no contract at all.
