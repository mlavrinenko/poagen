#import "@local/mindtape:0.2.0": *

#show: task.with(
  title: "Retire the human review gate and put the closing check on a machine",
  tags: ("process", "mindtape"),
  priority: 8,
  difficulty: 5,
  status: proposed(2026, 8, 1),
)

== Summary

The MindTape config shipped with \`done\` reachable only from \`needs-review\`, so no run of work could close itself. The reasoning was sound, and an audit on 2026-08-01 confirmed the risk is real: across fourteen tasks and 110 acceptance criteria, four overshot what had landed, one of them a live defect.

The gate still failed. Thirty-eight tasks accumulated in \`needs-review\` against a single human reviewer, all of them already merged and shipping. The status recorded an intention to review rather than a review, and the queue grew faster than anyone could read it.

A gate nobody can service is not a gate. It is worse than none, because it looks like diligence while the code ships unread.

== Acceptance criteria

- \`needs-review\` is gone from the status legend and \`wip\` transitions straight to \`done\`.
- Every task that was sitting in \`needs-review\` is closed, not stranded on a status that no longer exists.
- A decision artifact records the removal, what replaces it, and what it costs — including that a defect no automated check can see now reaches \`done\` unchallenged.
- The config comment that documented the old gate is rewritten, not left describing a mechanism that no longer exists.
- The \`\@review\` view is replaced by one that supports reading after the fact rather than gating before it.
- \`mt check\` and the full gate are green.

== Non-goals

- Pointing the \`\[\[on.flip\]\]\` predicate at a real freshness check. That is the substance of the replacement and has its own task; this one only clears the way for it.
- Re-auditing the tasks being closed. The audit that motivated this covered fourteen of them; the rest close unread, deliberately.
- Changing the four required body sections, which matter more under this change rather than less.

== Files

- \`.mindtape/config.toml\`
- \`truth/decisions/\`
- \`truth/main.typ\`
- \`truth/tasks/\`
