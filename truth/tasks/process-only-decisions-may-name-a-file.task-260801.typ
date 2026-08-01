#import "@local/mindtape:0.2.0": *

#show: task.with(
  title: "Record the process-only file-naming ruling as a decision artifact",
  tags: ("speconaut", "decisions"),
  priority: 6,
  difficulty: 4,
  status: done(2026, 8, 1),
)

== Summary

\`process-only-decisions-and-file-names\`'s own acceptance criterion asked for "a decision records whether \`process-only\` artifacts are exempt from the code-reference rule, with the reasoning either way." What exists instead is a \`=== Decided 2026-07-31: it may\` section inside the task file itself, plus two bullets appended to \`truth/decisions/code-references-permitted-in-generator-specs.decision-260729.typ\`. There is no decision artifact for the ruling. A task is a work item; once it reaches a terminal status the reasoning it carried effectively leaves the decisions tree, even though the task file itself is not deleted.

The ruling is also incomplete on its own terms. It keys the exemption upstream, on speconaut's \`process-only:\` slot rather than a paogen allowlist entry, reasoning that a blanket \`src/\` allowlist entry would re-exempt every artifact that should stay governed. That is the right call, but it means paogen's tree now depends on an unlanded speconaut change — filed there as \`code-refs-exempt-process-only-decisions\` — for the exemption to actually take effect. Today, \`plain-getopt-for-the-cli.decision-260417.typ:56\` already reads \`the PaogenCli's entry point bin/paogen is hand-rolled; src/Cli.php contains the dispatch\`, restored ahead of the upstream fix landing, and \`speconaut check truth/\` currently passes with the allowlist still narrowed to output vocabulary alone — so either the upstream behaviour already covers this case, or the check simply has not yet re-flagged it. Either way, the dependency is real and unrecorded: if speconaut's semantics around \`process-only:\` change before this decision exists, paogen has no artifact to point at and no local configuration to notice the drift.

The owner has authorised working in the speconaut tree where a paogen task genuinely depends on an upstream speconaut change, as this one does. That authorisation comes with one condition worth stating plainly in the resulting decision: any change made in speconaut's tree must be accompanied by a task filed in speconaut's own tree, not left as an out-of-band patch nobody there can find.

== Acceptance criteria

- A decision artifact under \`truth/decisions/\` records that a \`process-only\` decision may name a file, with the reasoning: such a decision is non-portable by construction — that is what the \`process-only:\` slot declares — so the code-reference rule was never aimed at it, and genericising a file name out of one buys no portability while costing the reader a pointer to what is being discussed.
- The decision states explicitly that the exemption is keyed on speconaut's \`process-only:\` slot, not a paogen allowlist entry, and names why (a blanket allowlist entry would re-exempt governed artifacts too).
- The decision names the upstream dependency by its speconaut-side identifier (\`code-refs-exempt-process-only-decisions\`) and states plainly that this ruling holds only once that change has landed — worded so the dependency cannot silently expire if the upstream task stalls or is reworked under a different name.
- If, at the time this task is done, the upstream change has not landed, the decision's \`process-only:\` or a companion note says so and points at the still-open upstream task rather than asserting the exemption is already in effect.
- Any work this task does inside the speconaut checkout is accompanied by a task filed in speconaut's own tree; this paogen task's Result section names that task by its speconaut-side identifier.
- \`process-only-decisions-and-file-names.task-260731.typ\` is updated to point at the new decision artifact rather than carrying the ruling itself, so the reasoning has one home.

== Non-goals

- Does not re-widen the paogen \`\[check.code-refs\]\` allowlist as an alternative way of granting the exemption; the upstream, slot-keyed route is the one already chosen.
- Does not revisit whether artifacts describing observable behaviour are exempt from the code-reference rule; that question is settled and out of scope here.
- Does not implement the upstream speconaut change itself beyond what is needed to file its task and, if authorised work is done there, land it — the fix's substance belongs to speconaut's own tree and task.

== Files

- \`truth/decisions/\`
- \`truth/decisions/code-references-permitted-in-generator-specs.decision-260729.typ\`
- \`truth/decisions/plain-getopt-for-the-cli.decision-260417.typ\`
- \`truth/tasks/process-only-decisions-and-file-names.task-260731.typ\`
