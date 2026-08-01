#import "@local/mindtape:0.2.0": *

#show: task.with(
  title: "Make analysis relaxation opt-in instead of opt-out",
  tags: ("standards", "strictness", "phpstan"),
  priority: 9,
  difficulty: 6,
  status: proposed(2026, 8, 1),
)

== Summary

\`truth/standards/analysis-runs-at-maximum-strictness.standard-260729.typ\` used to say analysis runs at its strictest setting over both the Generator and the tree it emits, with no baseline, no suppression annotation, no ignored-error pattern, and no excluded path. \`rewrite-agent-guide-for-mindtape\` (commit 312cd5f) rewrote that into a two-tier rule: the emitted tree still admits nothing, but the Generator's own analysis now permits an exemption wherever the tool is "provably blind," with an inline comment naming the blind spot.

The choice available at the time was either delete the seven \`ignoreErrors\` entries in \`phpstan.neon.dist\` and fix or restructure what they hid, or rewrite the standard so the existing config became compliant. The second path was taken, and taken first — the standard changed, then \`audit-phpstan-generator-exemptions\` was filed to check the seven against the new rule. That audit has never run, so nothing has actually verified the exemptions the rewrite legalised.

Two things are already provably wrong on today's tree. \`phpstan.neon.dist:19-22\` carries two entries — \`shipmonk.deadProperty.neverRead\` and \`property.onlyWritten\`, both scoped to \`tests/generated/\*Steps.php\` — with no inline comment at all, which the rewritten rule requires of every exemption. And the standard's \`structural:\` slot still claims "seven documented tool-blind-spot exemptions"; the file holds five (\`implement-the-outrun-step-bodies\` removed the \`staticMethod.dynamicCall\` entry), and the word "documented" was never true of the two uncommented ones.

The direction is to revert the relaxation rather than patch its symptoms. The standard's prose goes back to an unconditional strictest-setting rule with no permanent two-tier carve-out. The five \`ignoreErrors\` entries that exist today do not have to disappear in this task, but they stop being legalised policy and become recorded debt instead: a count the project can inspect, that is only ever allowed to shrink, and that a new entry can only join by carrying its own explicit, justified, inline-commented case. Relaxation becomes something a change has to argue for at the point it is added, never a standing default a standard can be reworded around.

== Acceptance criteria

- \`truth/standards/analysis-runs-at-maximum-strictness.standard-260729.typ\`'s rule text reverts to the pre-relaxation wording: strictest available setting over both tiers, no baseline, no suppression annotation, no ignored-error pattern, no excluded path — the "two tiers held to different absolutes" language is gone.
- Every \`ignoreErrors\` entry in \`phpstan.neon.dist\` is inventoried in this task's Result section by identifier and path, with a note on whether it already carries a blind-spot comment.
- The two uncommented entries (\`shipmonk.deadProperty.neverRead\` and \`property.onlyWritten\` on \`tests/generated/\*Steps.php\`) either gain an inline comment naming the specific tool blind spot, or are removed because the finding they hide is real and gets fixed.
- A recorded, checkable count of surviving exemptions exists (in the standard's \`structural:\` slot, a comment block, or a small script the gate can run), stated as a ceiling that may only decrease. Growing it requires a new inline comment naming the blind spot plus a reference to the task or decision that justified it — not a silent addition.
- \`audit-phpstan-generator-exemptions\` is either folded into this task's own work or explicitly resequenced against it, since as filed it audits the five exemptions against the exact rule this task rewrites back.
- A decision artifact records the reversal — relaxation is opt-in, never opt-out — so the next agent reading \`rewrite-agent-guide-for-mindtape\`'s commit message does not read the relaxation as the settled answer.

== Non-goals

- Does not fix the underlying findings the five \`ignoreErrors\` entries hide; that inventory and any fix is \`audit-phpstan-generator-exemptions\`'s remit, sequenced against this task rather than duplicated here.
- Does not touch \`phpstan-generated.neon\`, the consumer-view tier. It was never relaxed and stays absolute.
- Does not prescribe the exact shape of the debt-tracking mechanism (a comment convention, a checked count, a small assertion in the gate) — only that one exists and is enforced, not merely written down.

== Files

- \`truth/standards/analysis-runs-at-maximum-strictness.standard-260729.typ\`
- \`phpstan.neon.dist\`
- \`truth/tasks/audit-phpstan-generator-exemptions.task-260729.typ\`
- \`truth/decisions/\`
