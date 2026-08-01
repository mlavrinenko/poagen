#import "@local/mindtape:0.2.0": *

#show: task.with(
  title: "Point the closing predicate at the gate instead of a placeholder grep",
  tags: ("process", "mindtape"),
  priority: 8,
  difficulty: 4,
  status: done(2026, 8, 1),
)

== Summary

Removing \`needs-review\` made the \`\[\[on.flip\]\]\` predicate on the way into \`done\` the only thing standing between a claim and a closed task. It is currently the preset's floor: a grep that refuses a task still carrying template \`TODO:\` placeholders. That catches an unwritten task. It cannot catch a task whose work does not pass the project's own gate.

The config's own comments already say what this should be — an assertion that the gate last passed against this worktree with its inputs unchanged, rather than a full build inside \`mt flip\`. A build in the hook is slow, fires at the worst moment, and teaches whoever hits it to reach for \`--force\`, which removes the gate entirely.

One constraint the comments call out and any implementation must respect: the freshness inputs have to exclude the task files themselves. \`mt flip\` writes the artifact it is gating, so a rule keyed on the whole tree goes stale the instant a status is stamped and can never pass again.

== Acceptance criteria

- Flipping a task to \`done\` fails when the project gate has not passed against the current worktree.
- The predicate asserts freshness rather than running the gate, so a normal close stays fast enough that nobody reaches for \`--force\` to avoid it.
- The freshness inputs exclude the task artifacts, and a stamped status does not invalidate the assertion.
- The existing \`TODO:\` placeholder refusal survives, whether folded into the new predicate or kept alongside it.
- Reaching for \`mt done --force\` still records the override in the status note.
- A task whose work fails the gate is demonstrated to be refused, not merely asserted to be.

== Non-goals

- Reinstating a human review status. That was decided against and the decision is recorded.
- Making the project gate itself faster or more thorough.
- Wiring \`mt check\` back into the gate, which is blocked on the config-skew task and is a different problem.

== Files

- \`.mindtape/config.toml\`
- \`Justfile\`
- \`CONTRIBUTING.md\`
