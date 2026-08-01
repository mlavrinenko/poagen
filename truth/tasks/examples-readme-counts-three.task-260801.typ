#import "@local/mindtape:0.2.0": *

#show: task.with(
  title: "The examples README still describes three examples when there are four",
  tags: ("docs", "examples"),
  priority: 3,
  difficulty: 1,
  status: done(2026, 8, 1),
)

== Summary

\`examples/README.md\` has a section headed "The three examples" and an ASCII diagram beside it, and neither mentions kilbil. There are four: petstore, kilbil, digitalocean and github.

kilbil is not a minor omission either — it is the end-to-end proof the generator was driven against, the schema that surfaced the transport collapse, the sub-client split and the XML request-body work. A reader arriving at the examples folder is told the most load-bearing one does not exist.

Pre-existing staleness, spotted while restructuring the examples to check themselves and deliberately left alone there to avoid widening that change.

== Acceptance criteria

- The section heading and the diagram both account for all four examples, and neither states a count that a fifth example would falsify.
- kilbil's entry says what it is for — the real vendor schema the generator was proven against — rather than listing it as one more sample.
- The expected-failure state of digitalocean and github is visible to a reader of the README, not only to someone who runs the check and reads the warning.
- Nothing in the file describes the pre-restructuring layout: each example now carries its own Justfile and PHPStan config, and the root fans out to them.

== Non-goals

- Adding, removing or regenerating any example.
- Documenting the expected-failure mechanism in depth; a pointer to the owning task is enough.
- Touching the per-example READMEs, if any.

== Files

- \`examples/README.md\`
