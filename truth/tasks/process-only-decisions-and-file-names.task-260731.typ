#import "@local/mindtape:0.2.0": *

#show: task.with(
  title: "Decide whether a process-only decision may name a file",
  tags: ("speconaut",),
  priority: 3,
  difficulty: 4,
  status: status("needs-review", 2026, 7, 31),
)

== Summary

Narrowing the code-reference exemption means no artifact under \`truth/\` may name a path in paogen's own tree. That is right for anything describing observable behaviour, and questionable for one category.

\`plain-getopt-for-the-cli.decision-260417.typ\` is a \`process-only\` decision: it records why paogen hand-rolls argument parsing instead of taking a dependency. It is inherently non-portable — a reimplementation would make its own call — so genericising \`bin/paogen\` and \`src/Cli.php\` out of it buys no portability, and costs a maintainer the one-hop pointer to where the thing being discussed lives.

The pilot rewrote it to satisfy the rule's letter and flagged that the letter and the purpose diverge there. This task decides which wins.

=== Decided 2026-07-31: it may

A \`process-only\` decision may name a file. It is non-portable by construction —
that is what the slot declares — so the rule was never aimed at it.

The exemption belongs upstream, keyed on the \`process-only:\` slot the checker
already reads, not on a paogen allowlist entry: a blanket \`src/\` entry would
re-exempt every artifact that should stay governed. Filed as
\`code-refs-exempt-process-only-decisions\` in the speconaut repo.

Once that lands, restore the \`bin/paogen\` and \`src/Cli.php\` pointers that
\`plain-getopt-for-the-cli\` lost, with the allowlist still narrowed to output
vocabulary alone.

== Acceptance criteria

- a decision records whether \`process-only\` artifacts are exempt from the code-reference rule, with the reasoning either way
- if they are exempt, the exemption is expressed in config rather than in a convention nobody enforces
- if they are not, \`plain-getopt-for-the-cli\` stays as the pilot rewrote it and the decision says why the maintainer pointer is worth losing

== Non-goals

- does not re-widen the allowlist as a way of avoiding the question
- does not revisit the rule for artifacts that describe behaviour; those are settled

== Files

- TODO: paths this task expects to change
