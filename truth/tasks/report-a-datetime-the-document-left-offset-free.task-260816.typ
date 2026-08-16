#import "@local/mindtape:0.2.0": *

#show: task.with(
  title: "Report a date-time the document left offset-free",
  tags: ("generator", "reporting"),
  priority: 3,
  difficulty: 3,
  status: done(2026, 8, 16),
  links: (
    related("an-offset-free-datetime-takes-an-explicit-zone.task-260816.typ"),
    related("a-profile-states-the-documents-timezone.task-260816.typ"),
  ),
)

== Summary

The other two tasks give a consumer two places to state which zone an
offset-free `date-time` means. Neither helps a consumer who does not know
they have the problem, and that is the normal case: the value hydrates, the
type is `\DateTimeImmutable`, nothing fails, and the error is a whole number
of hours wide in a field nobody re-reads. The kilbil consumer found it from a
customer-visible symptom, not from the client.

`FormatAdvisor` is already the answer to exactly this shape of silence. Its
own docblock says so: an unknown format falls through to the base type, which
carries the value, and reporting exists because doing it quietly "loses the
one thing the consumer would have wanted to know". It reports and does
nothing else — `silence-means-success` distinguishes a run that shrank the
client from a run that could be more pleasant, and this is the second kind.

An offset-free `date-time` is the second kind too. RFC 3339 requires the
offset, so a document whose examples omit it is off-spec in a way poagen can
see at generation time, and the consequence — the process timezone decides
what the value means — is worth one line on stderr.

== Acceptance criteria

- A run over a document whose `date-time`/`date` examples carry no offset
  prints one line naming the format, a use count, and one place it appeared,
  the same shape the unrecognised-format report already uses.
- It names the two ways to answer it: the profile's document-wide statement
  and the runtime `BindingContext`.
- The exit status does not move. Nothing is omitted from the emitted tree,
  so this is advisory exactly as the existing report is.
- A document whose examples carry offsets prints nothing. Neither does a
  document with no `date-time` at all.
- REVERSED while building this. The criterion here said a `date-time` with no
  example anywhere should be reported too, on the reasoning that poagen
  cannot tell a compliant one from an off-spec one and that saying so is
  cheaper than a wrong instant. It is not: most documents carry no
  per-property examples at all, so that rule fires on nearly every run, and
  an advisory that always fires is one readers learn to skip — which would
  cost the case it exists for. Evidence is now required: a property is
  reported only when its own `example` or `default` shows a timestamp with no
  offset, the document convicting itself. `silence-means-success` only means
  something while silence is earned.
- Covered by a test over a fixture document of each kind.
- `just check` green.

== Non-goals

- Failing the run. The value hydrates and the client is whole;
  `silence-means-success` puts this on the advisory side.
- Inferring the zone from an example. Reporting that the document did not say
  is the whole point; guessing what it meant is the opposite of it.
- Reporting anything about a `ScalarBinding` a consumer bound to the format.
  A consumer who wrote the value object has already been told the format
  exists — that is what binding it means.
- Reporting `format: date`. A date-only value carries no offset by its own
  definition, so a rule covering it would fire on every document that has a
  date at all and report a fact rather than a defect.

== Files

- `src/Generator/Emit/FormatAdvisor.php`
- `tests/`
- `truth/decisions/`
