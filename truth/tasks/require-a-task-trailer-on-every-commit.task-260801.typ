#import "@local/mindtape:0.2.0": *

#show: task.with(
  title: "Hook the commit message to require a task trailer",
  tags: ("git", "hooks", "process"),
  priority: 7,
  difficulty: 4,
  status: proposed(2026, 8, 1),
)

== Summary

\`CONTRIBUTING.md\` states the trailer policy \`settle-refs-footer-policy\` settled: every commit carries a \`Refs: \<slug>\` trailer naming the task it belongs to, and "work with no task behind it needs a task first — that is the point of the trailer, not a formality it satisfies." That rule is the strictest available reading — there is no such thing as a commit without a task — and it was deliberately left unenforced: \`settle-refs-footer-policy\`'s own Non-goals named enforcement as "a separate decision."

Nothing currently checks it. \`.git/hooks/\` holds only the sample hooks Git ships by default; there is no \`commit-msg\` hook, no \`lefthook\`/\`husky\`-style config, and no CI step reading trailers. A convention that only a careful human or agent chooses to honour is exactly the kind the review-gate removal (\`review-gate-must-be-mechanical\`) argues against: a rule with no machine behind it is a stated intention, not a gate.

The hook needs to accept two shapes, not just the trailer: a \`Refs: \<slug>\` line, or a Conventional Commits type of \`dev\` or \`chore\`, which \`git dev:\`/\`chore:\`-prefixed commits already use for work that genuinely has no task behind it (tooling housekeeping, a stray formatting pass) rather than forcing a task to exist for its own sake. Checking that the trailer line is present is not enough on its own — a hook that only pattern-matches \`Refs: \` would pass a typo'd slug, a slug for a task that was renamed out from under it, or a slug that was simply invented. The hook has to resolve the slug against \`truth/tasks/\` and fail if no file matches \`\<slug>.task-\<yymmdd>.typ\`.

== Acceptance criteria

- A \`commit-msg\` git hook is added to the repository (under a tracked hooks directory such as \`.githooks/\`, since \`.git/hooks/\` itself is not version-controlled) and documented in \`CONTRIBUTING.md\` with the one-time setup step a contributor runs to point Git at it.
- The hook accepts a commit whose message carries at least one \`Refs: \<slug>\` trailer, or whose Conventional Commits type is \`dev\` or \`chore\`. Any other commit is rejected with a message stating which of the two conditions it failed.
- For every \`Refs: \<slug>\` trailer present, the hook resolves \`\<slug>\` against \`truth/tasks/\` and rejects the commit if no file matching \`\<slug>.task-\<yymmdd>.typ\` exists. A trailer naming a task that was retired to a tombstone is treated as not resolving, since the live task no longer exists under that name.
- A commit spanning several tasks (\`settle-refs-footer-policy\`'s repeated-trailer case) passes as long as every trailer line present resolves.
- The hook is tested: at minimum, one case proving a valid slug passes, one proving an invented slug fails, one proving a bare \`dev:\`/\`chore:\` commit with no trailer passes, and one proving a commit with neither is rejected.
- The hook's existence and behaviour are recorded in \`CONTRIBUTING.md\` alongside the trailer policy \`settle-refs-footer-policy\` already documents, so the two live next to each other rather than the hook being discoverable only by finding the script.

== Non-goals

- Does not change the trailer format, the slug-derivation rule, or which Conventional Commits types exist; it enforces the policy \`settle-refs-footer-policy\` already recorded, not a new one.
- Does not retroactively validate historical commits, which predate the hook and the policy alike.
- Does not install the hook automatically on clone; a documented one-time setup step is sufficient, matching how the project already expects a contributor to run \`composer install\` by hand.
- Does not fold this into the speconaut session workflow's own pre-commit hook shim, which is a separate, currently-declined mechanism (\`turn-on-the-speconaut-session-workflow\` owns that question) and would tie this hook's fate to a decision this task does not need to wait on.

== Files

- \`.githooks/\`
- \`CONTRIBUTING.md\`
- \`truth/tasks/settle-refs-footer-policy.task-260728.typ\`
