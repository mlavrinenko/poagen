#import "@local/mindtape:0.2.0": *

#show: task.with(
  title: "Generate a working kilbil loyalty client as the end-to-end proof",
  tags: ("proof",),
  priority: 8,
  difficulty: 5,
  status: accepted(2026, 7, 29),
)

== Summary

The project needs one real, published, unfriendly schema it demonstrably serves end to end, rather than a corpus chosen to suit the generator. The kilbil loyalty document is that schema: it is 3.1, declares 36 operations and zero components, inlines every payload, uses unseparated lowercase operation identifiers, and carries invented and misspelled format annotations. Today it produces two files and exits successfully. This task is the acceptance run for the goals, not a feature in itself, and it lands once the 3.1, inline-schema, interface and strictness tasks are done.

== Acceptance criteria

- All 36 operations appear on the generated client with typed parameters and typed return values.
- The generated tree passes the project's strictest analysis with no baseline and no suppressions.
- A hand-written wrapper implementing the emitted interface adds at least one convenience method without any edit to the generated tree.
- Regenerating twice in a row produces no diff.
- The example ships under the examples tree with its profile, and the check-examples recipe covers it.
- The unfriendly parts — the misspelled date-time format, the phone format, the unseparated identifiers — are handled from the profile, not by editing the vendor document.

== Non-goals

- Contacting the vendor about their schema.
- Committing any credential; the example is generation-only and makes no live call.

== Files

- \`examples/kilbil/\`
- \`Justfile\`
