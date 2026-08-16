#import "@local/mindtape:0.2.0": *

#show: task.with(
  title: "An offset-free date-time takes an explicit zone, not the process one",
  tags: ("runtime", "hydration"),
  priority: 3,
  difficulty: 6,
  status: accepted(2026, 8, 16),
  links: (
    related("a-profile-states-the-documents-timezone.task-260816.typ"),
    related("report-a-datetime-the-document-left-offset-free.task-260816.typ"),
  ),
)

== Summary

`Hydrator::decodeDateTime()` is `new DateTimeImmutable(#raw("$value"))`
(`runtime/src/Marshal/Hydrator.php:142`). RFC 3339 requires an offset on a
`date-time`, so a document whose values carry none is off-spec — and for those
values that line silently applies the process timezone. The same wall clock
therefore means different instants on a developer's machine and in a UTC
container, with nothing said on either.

Measured in a consumer. The kilbil loyalty API returns `move_date`,
`bonus_in_date` and `bonus_term_date` as bare `2026.08.14 12:51:17`, Moscow
time, no offset anywhere in the document. In a UTC container that arrives
labelled UTC, and the consumer's own view re-renders it three hours late for
every row of a customer's bonus history. The consumer's `Timestamp` value
object is `ScalarBinding` and hits the second half of the same hole:
`decodeScalarBinding()` calls `#raw("$class")::fromScalar(#raw("$value"))`
statically (`Hydrator.php:182`), so no per-client configuration can reach it
either.

Both halves are one issue: a value the document left ambiguous is resolved
from ambient process state instead of from something the consumer stated.

The seam already exists and this repo already uses it for the sibling problem.
`HttpTransport` takes `?MarshallerInterface` and `?HydratorInterface`
(`runtime/src/Http/HttpTransport.php:72-92`), and the kilbil consumer injects
`OmitNullMarshaller` there because that vendor rejects explicit nulls. A zone
is the same kind of fact, answered in the same place, per client instance,
with no global mutable state.

PHP's own behaviour makes this safe to apply as a blanket per-client default,
verified on PHP 8.4.17: a string that carries its own offset ignores the
timezone argument — `new DateTimeImmutable('2026-08-14T12:51:17+05:00',
#raw("$msk"))` stays `+05:00`. So the setting only ever repairs off-spec
values and never overrides a compliant one, and a document that mixes both
behaves correctly under a single zone.

== Acceptance criteria

- A consumer can state one timezone at client construction and have it apply
  to every offset-free `date-time`/`date` the document hydrates, without
  regenerating anything.
- The same statement reaches `ScalarBinding` value objects, not only the
  built-in `\DateTimeImmutable` path. A binding that does not opt in keeps
  working through the existing static `fromScalar()`, unchanged.
- Serialisation is symmetric: whatever a value object is told about the zone
  on the way in, it can read on the way out, so a round trip through the
  wire is stable.
- A value that already carries an offset is unaffected — asserted by a test
  that hydrates a compliant and an offset-free value under the same
  configured zone and gets `+05:00` and the configured zone respectively.
- Stating nothing changes nothing: every existing golden tree is
  byte-identical, every existing consumer keeps its current behaviour, and
  `ScalarBinding` stays a valid thing to implement on its own.
- `Bindings::scalarBindingType()`'s `is_a(#raw("$fqcn"), ScalarBinding::class,
  true)` check still passes for an opted-in binding, so the emitter is not
  touched and no fixture or example tree regenerates.
- `just check`, `just check-examples` and `just verify-runtime-standalone`
  green end-to-end.

== Non-goals

- Deciding what any particular document's zone is. That is the consumer's
  statement to make; this is the mechanism that carries it. The document-wide
  half is `a-profile-states-the-documents-timezone`.
- Reporting an offset-free document at generation time. That is
  `report-a-datetime-the-document-left-offset-free`.
- Per-operation or per-property zones. A document that genuinely returns
  different zones per call is not this shape of problem — it is
  `propertyFormats` plus a value object that knows, which already works.
- Changing the default when nothing is stated. Keeping the process timezone
  is the compatible behaviour; making it loud is the sibling task's job.
- Any emitter change. If this needs one, the design is wrong.

== Files

- `runtime/src/BindingContext.php`
- `runtime/src/ContextualScalarBinding.php`
- `runtime/src/Marshal/Hydrator.php`
- `runtime/src/Marshal/Marshaller.php`
- `runtime/src/Http/HttpTransport.php`
- `runtime/tests/`
- `truth/decisions/`
