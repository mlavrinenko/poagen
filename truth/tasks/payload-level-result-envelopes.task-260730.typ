#import "@local/mindtape:0.2.0": *

#show: task.with(
  title: "Record that a failure inside a 200 body stays the consumer's business",
  tags: ("generator", "errors", "decision"),
  priority: 5,
  difficulty: 2,
  status: accepted(
    2026,
    8,
    2,
  )[Owner ruled 2026-08-02: a payload-level result envelope stays entirely the consumer's business. What remains is the decision artifact and the README line.],
)

== Summary

The kilbil vendor signals failure in a \`result\_code\` property carried by a 200 response, not in the HTTP status. \`examples/kilbil/src/PhoneConfirmation.php:66\` encodes that by hand, one endpoint at a time:

\`\`\`php
return \$response->result\_code === '0';
\`\`\`

Every one of the 36 operations returns a \`result\_code\`, and \`ApiException\` only ever fires on the vendor's 403. So a caller who checks nothing gets a response object that looks successful and is not — the exact silent failure \`fail-loud-never-silent\` exists to prevent, arriving through a door the goal does not currently watch.

The envelope is not a kilbil quirk; payload-level status codes are common in older APIs. But OpenAPI does not mark which property is the status, and the meaning of its values is vendor knowledge paogen cannot derive. So the open question is whether this stays entirely the consumer's business — as \`PhoneConfirmation\` shows it can be — or whether the profile grows a way to declare the envelope and the generator does something with it.

This needs a decision artifact before code.

=== Owner ruling, 2026-08-02

A payload-level result envelope stays entirely the consumer's business. The
profile grows no surface for it and the generator does nothing with it. What
remains is writing that down: the decision artifact, and the line in the
example's README where a reader first meets the field.

== Acceptance criteria

- A decision artifact under \`truth/decisions/\` records the choice — consumer's
  business — with its options and consequences, citing at least one goal and
  one standard.
- The options it weighs include at minimum: leave it to consumer wrappers as
  today; declare the envelope in the profile and have the generator throw;
  declare it and have the generator expose a typed predicate without throwing.
- The decision states why a generator answer would be worse, and names what
  would reopen it. The load-bearing reason: the vendor's own document never
  marks the property, so the generator would be acting on guidance that is
  pure vendor knowledge, and a wrong guess turns a success into a thrown
  exception on an operation that worked.
- \`examples/kilbil/README.md\` says so where a reader meets \`result\_code\`,
  pointing at the wrapper the example already ships.
- Nothing under \`src/\` or \`runtime/src/\` changes.

== Non-goals

- \`typed-error-responses\`, which asks whether declared error schemas become typed exception classes. That is about responses OpenAPI marks as errors; this is about responses it marks as successes.
- Retry, backoff, or any transport concern.

== Files

- \`truth/decisions/\`
- \`examples/kilbil/README.md\`
