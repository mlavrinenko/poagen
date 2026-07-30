#import "@local/mindtape:0.2.0": *

#show: task.with(
  title: "Decide whether a process-only decision may name a file",
  tags: ("speconaut",),
  priority: 3,
  difficulty: 4,
  status: proposed(2026, 7, 31),
)

== Summary

Narrowing the code-reference exemption means no artifact under \`truth/\` may name a path in paogen's own tree. That is right for anything describing observable behaviour, and questionable for one category.

\`plain-getopt-for-the-cli.decision-260417.typ\` is a \`process-only\` decision: it records why paogen hand-rolls argument parsing instead of taking a dependency. It is inherently non-portable — a reimplementation would make its own call — so genericising \`bin/paogen\` and \`src/Cli.php\` out of it buys no portability, and costs a maintainer the one-hop pointer to where the thing being discussed lives.

The pilot rewrote it to satisfy the rule's letter and flagged that the letter and the purpose diverge there. This task decides which wins.

== Acceptance criteria

- a decision records whether \`process-only\` artifacts are exempt from the code-reference rule, with the reasoning either way
- if they are exempt, the exemption is expressed in config rather than in a convention nobody enforces
- if they are not, \`plain-getopt-for-the-cli\` stays as the pilot rewrote it and the decision says why the maintainer pointer is worth losing

== Non-goals

- does not re-widen the allowlist as a way of avoiding the question
- does not revisit the rule for artifacts that describe behaviour; those are settled

== Files

- TODO: paths this task expects to change
