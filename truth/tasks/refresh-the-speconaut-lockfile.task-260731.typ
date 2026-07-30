#import "@local/mindtape:0.2.0": *

#show: task.with(
  title: "Refresh the speconaut lockfile against the current truth tree",
  tags: ("speconaut",),
  priority: 6,
  difficulty: 3,
  status: proposed(2026, 7, 31),
)

== Summary

\`.speconaut/state.lock\` was last written 2026-04-21 and records a tree that no longer exists. All four spec paths it names — \`truth/specs/{model-generator,operation-generator,profile,cli}.typ\` — predate the \`.feature-\<yymmdd>\` rename and are gone from disk. Five of its 76 traced source paths were renamed or deleted. It holds 74 scenarios; the tree now has 93.

Nothing in it can verify, so \`speconaut status\` and \`speconaut diff\` report against a fiction and \`check-drift\` cannot honestly sit in the gate.

== Acceptance criteria

- \`speconaut lock\` completes against the current tree
- every spec path in \`.speconaut/state.lock\` names a \`.feature-\<yymmdd>.typ\` file that exists
- every traced source path in the lockfile exists on disk
- \`speconaut lock --check\` exits 0 on a clean tree
- \`speconaut status\` reports zero content mismatches

== Non-goals

- does not restore coverage-derived traces; \`restore-coverage-derived-traceability\` owns that
- does not promote any scenario to \`mature\` — every scenario stays \`unstable\` this milestone
- does not edit scenario prose to make the lock converge

== Files

- \`.speconaut/state.lock\`
- \`Justfile\`
