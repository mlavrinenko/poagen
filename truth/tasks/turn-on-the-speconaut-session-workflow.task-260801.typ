#import "@local/mindtape:0.2.0": *

#show: task.with(
  title: "Turn the speconaut session workflow back on",
  tags: ("speconaut", "process"),
  priority: 5,
  difficulty: 5,
  status: proposed(2026, 8, 1),
  links: depends-on(
    "restore-coverage-derived-traceability.task-260729.typ",
  ),
)

== Summary

\`declare-paogen-runs-no-sessions\` set \`\[session\] enabled = false\` in \`.speconaut/config.toml\`. The comment above it is thorough about what the opt-out costs — \`speconaut lock\`'s FSM ordering check and its spec-first diff baseline are both session-shaped, so for a project that never opens one they are "undefined rather than skipped" — but the ruling itself lives only in that comment. No decision artifact records it, unlike \`plain-getopt-for-the-cli\`, which records a far smaller tooling choice as a proper decision. An opt-out recorded only as a config comment silences every one of the 31 lifecycle-provenance warnings the project used to see on \`done\`/\`cancelled\` tasks, permanently, with nothing short of reading that comment to know it was a choice rather than an oversight.

An opt-out is not a permanent state; it is a task to revert once its blockers clear, the same way a skip-listed operation or a PHPStan exemption is expected to come back once its cause stops holding. This task owns turning the workflow on, which means owning the real, currently-open blocker rather than re-declaring the opt-out or waiting indefinitely.

One blocker the config comment named has already resolved on this tree, worth recording so nobody re-derives it: \`session-opt-out-does-not-reach-lock\` fixed the \`audit-traces\` adapter name upstream, and \`tests/generated/manifest.json\` now exists with zero remaining \`Implement:\` step stubs, both verified directly against HEAD. A read-only check confirms \`speconaut lock --check\` and \`speconaut status\` both run to completion today with no adapter or manifest error — the specific failure the config comment described (\`env: 'php': No such file or directory\` resolves once run inside the project's own devbox/direnv shell; the manifest-missing error the comment worried about does not reproduce at all).

What remains genuinely open is traceability. \`speconaut status\` currently reports all four feature files as \`untraced\`, and \`restore-coverage-derived-traceability\` — still \`proposed\` — is the task that wires the coverage-derived trace pipeline all the way through: running \`generate-tests\` for real, comparing reported coverage against declarations without erroring, and deciding what an uncovered source file means. Until that lands, the \`session specs\` command's "affects from the trace map" half has nothing trustworthy to derive from, which is exactly the spec-first diff baseline the opt-out comment named as undefined. That is this task's real, linked blocker.

== Acceptance criteria

- \`restore-coverage-derived-traceability\` is done, or this task's Result section demonstrates the trace map is trustworthy enough for \`speconaut session specs\` to derive a meaningful blast radius without it.
- A decision artifact records that the workflow is turned on, superseding \`declare-paogen-runs-no-sessions\`'s opt-out rather than leaving both as separate, seemingly-contradictory states in \`truth/decisions/\`.
- \`\[session\] enabled = false\` in \`.speconaut/config.toml\` is flipped, with the comment above it rewritten to describe the on-state — what \`session start\` installs (the pre-commit hook shim), how a task branch is expected to open and close one, and what the FSM ordering check now actually verifies now that opening one is real.
- A full task lifecycle — \`session start\` against a real task, at least one commit, \`session check\`, \`lock\`, \`session close\` — is exercised and its outcome recorded, proving the mechanism works end to end rather than merely toggling the flag.
- The 31-warning lifecycle-provenance regression the opt-out silenced is checked against the current task count; if turning sessions on reintroduces warnings against already-\`done\` tasks that never opened one, this task records how those are treated (grandfathered, or a one-time backfill) rather than leaving the gate red on day one.

== Non-goals

- Does not implement \`restore-coverage-derived-traceability\` itself; this task links to it as a dependency and waits, or does the minimum needed to demonstrate the trace map is sound enough, rather than absorbing that task's scope.
- Does not change the trailer or hook policy \`require-a-task-trailer-on-every-commit\` owns; the speconaut session pre-commit shim and any commit-trailer hook are independent mechanisms that may need to coexist, not merged into one.
- Does not reopen whether \`speconaut-mindtape-config-skew\`'s \`\[\[on.flip\]\]\` parsing issue affects sessions; that task is tracked separately and this task does not depend on it unless testing the full lifecycle surfaces a real interaction.

== Files

- \`.speconaut/config.toml\`
- \`truth/decisions/\`
- \`truth/tasks/declare-paogen-runs-no-sessions.task-260731.typ\`
- \`truth/tasks/restore-coverage-derived-traceability.task-260729.typ\`
