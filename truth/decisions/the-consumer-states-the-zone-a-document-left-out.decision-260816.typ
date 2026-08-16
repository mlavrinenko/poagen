#import "@local/speconaut:0.1.0": *
#import "../domain/runtime.context.typ": *

#show: decision.with(
  title: "the consumer states the zone a document left out, per client instance",
  status: accepted(2026, 8, 16),
  contexts: (runtime-context,),
  goals: (
    link("../goals/declared-shapes-become-types.goal.typ"),
    link("../goals/user-code-guides-generation.goal.typ"),
  ),
  standards: (link("../standards/caller-surface-is-injectable.standard-260729.typ"),),
)

== Context

RFC 3339 requires an offset on a `date-time`, and real documents omit it.
`Marshal\Hydrator::decodeDateTime()` was `new DateTimeImmutable($value)`, so
such a value was resolved against the PROCESS timezone: the same payload
meant different instants on a developer's machine and in a UTC container,
and nothing said so on either.

The kilbil loyalty API is the measured case. `move_date`, `bonus_in_date`
and `bonus_term_date` arrive as bare `2026.08.14 12:51:17`, Moscow time, with
no offset anywhere in the document and no prose naming a zone. Read in a UTC
container, a customer's whole bonus history rendered three hours late. The
consumer found it by comparing their own screen against the vendor's, not
from anything the client said — the type was right and the value was wrong.

The second half of the hole was `Marshal\Hydrator::decodeScalarBinding()`,
which calls `$class::fromScalar($value)` statically. That consumer's own
`Timestamp` value object is exactly where the repair belonged, and no
configuration could reach it.

== Choice

`Runtime\BindingContext` carries what the consumer knows about the
installation and the document could not state — today one field, `$naiveZone`
— and is handed to the hydrator and the marshaller at construction.
`HttpTransport` takes it as its last optional argument and passes it to the
marshaller and hydrator it defaults, which is the same seam
`caller-surface-is-injectable` already opens for those two collaborators, and
the same one a consumer uses to inject `Marshal\OmitNullMarshaller` for a
vendor that rejects explicit nulls.

`Runtime\ContextualScalarBinding` extends `ScalarBinding` with a context-aware
pair. Extending rather than replacing is what keeps the change free:
`Generator\Bindings::scalarBindingType()` asks
`is_a($fqcn, ScalarBinding::class, true)`, which an opted-in binding still
satisfies, so the emitter is untouched and no fixture, example or consumer
tree regenerates because a value object opted in. The plain methods stay
declared, because a Model constructed by hand never passes a transport and
must still work.

Three properties decided the shape:

- Per instance, not global. The zone is a fact about the installation, and
  one published document serves many. Two clients in one process disagree
  correctly, which a constant in a value object cannot do and a static
  setter could only do by being mutable global state.
- Narrow by construction. PHP ignores the zone argument when the string
  carries its own offset, so a stated zone repairs off-spec values and can
  never overwrite a compliant one. A document mixing both needs no special
  handling.
- Silent by default. Stating nothing keeps the process timezone, so every
  existing consumer's output is unchanged. That default is deliberately not
  defended as good — it is compatible, which is a different claim, and
  `report-a-datetime-the-document-left-offset-free` is where it stops being
  quiet.

The dispatch — is this binding context-aware — lives on the context itself,
in `hydrateBinding()` and `scalarOf()`, rather than in the hydrator and the
marshaller. Both need the identical answer, and a second copy of that
question is a second place for the two directions to diverge.

== Consequences

Where the zone comes FROM is not settled here. When a vendor fixes one zone
for every installation, restating it at each construction site is
restatement, and `a-profile-states-the-documents-timezone` is where that
belongs — the precedence being context over profile over process, which
mirrors `Bindings::scalarFormat()`'s existing per-property over document-wide
over built-in ordering.

Per-operation and per-property zones stay out of reach of this mechanism on
purpose. A document that genuinely returns different zones per call is
answered by `propertyFormats` and a value object that knows, which already
works; widening the context to cover it would make one global answer look
like it could express a per-call one.

`BindingContext` is a struct with one field today and is expected to grow
others: it is the named home for anything a consumer knows and a document
cannot say. Adding a field there is additive for every existing consumer,
which is the property that makes it worth having as a type rather than
passing a `DateTimeZone` around.
