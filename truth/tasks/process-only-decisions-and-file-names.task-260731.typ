#import "@local/mindtape:0.2.0": *

#show: task.with(
  title: "Decide whether a process-only decision may name a file",
  tags: ("speconaut",),
  priority: 3,
  difficulty: 4,
  status: done(2026, 8, 1),
)

== Summary

Narrowing the code-reference exemption means no artifact under \`truth/\` may name a path in paogen's own tree. That is right for anything describing observable behaviour, and questionable for one category.

\`plain-getopt-for-the-cli.decision-260417.typ\` is a \`process-only\` decision: it records why paogen hand-rolls argument parsing instead of taking a dependency. It is inherently non-portable — a reimplementation would make its own call — so genericising \`bin/paogen\` and \`src/Cli.php\` out of it buys no portability, and costs a maintainer the one-hop pointer to where the thing being discussed lives.

The pilot rewrote it to satisfy the rule's letter and flagged that the letter and the purpose diverge there. This task decides which wins.

=== Decided 2026-07-31: it may

The ruling now lives where a ruling belongs — as
\`truth/decisions/process-only-decisions-may-name-a-file.decision-260801.typ\`,
written by \`process-only-decisions-may-name-a-file\`. Read it there rather than
here; a decision recorded only in the body of a closed task is one the next
reader has no reason to look for.

In short: a \`process-only\` decision may name a file, because it is non-portable
by construction — that is what the slot declares — so the rule was never aimed
at it. The exemption is keyed upstream on the \`process-only:\` slot the checker
already reads, not on a paogen allowlist entry, since a blanket \`src/\` entry
would re-exempt every artifact that should stay governed.

The upstream change it waited on has landed, and the decision artifact names it
explicitly so the dependency cannot silently expire.

== Acceptance criteria

- a decision records whether \`process-only\` artifacts are exempt from the code-reference rule, with the reasoning either way
- if they are exempt, the exemption is expressed in config rather than in a convention nobody enforces
- if they are not, \`plain-getopt-for-the-cli\` stays as the pilot rewrote it and the decision says why the maintainer pointer is worth losing

== Non-goals

- does not re-widen the allowlist as a way of avoiding the question
- does not revisit the rule for artifacts that describe behaviour; those are settled

== Files

- \`truth/decisions/plain-getopt-for-the-cli.decision-260417.typ\`
- \`truth/decisions/code-references-permitted-in-generator-specs.decision-260729.typ\`
