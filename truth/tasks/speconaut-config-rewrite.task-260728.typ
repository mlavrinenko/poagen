#import "@local/mindtape:0.2.0": *

#show: task.with(
  title: "Rewrite .speconaut/config.toml for the current config schema",
  tags: ("speconaut",),
  priority: 8,
  difficulty: 2,
  status: proposed(2026, 7, 28),
)

== Summary

\`just check-specs\` fails before doing any work: \`speconaut check\` rejects the config with \`unknown field \`traces\`\`. The file still uses the retired \`\[traces\] source-dirs\` key. The current schema accepts \`truth-path\`, \`format-command\`, \`output-dir\`, \`audit-traces\`, \`check\`, \`orientation\`, \`session\`, \`status\`, \`tasks\`. This is the first blocker in the speconaut recovery chain — nothing else in the truth tree can be validated until the tool will load the project at all.

== Acceptance criteria

- \`speconaut check\` loads the project and reports errors about artifact content, not about the config file.
- Config declares \`truth-path\`, \`output-dir\` pointing at the generated PHPUnit tests, and \`\[check\] source-roots\` / \`spec-roots\`.
- \`\[check.code-refs\] allowlist\` covers the PHP identifier shapes paogen's specs legitimately name (see the sibling code-ref task), or that task is filed and linked.
- No key in the file is rejected by the current binary.

== Non-goals

- Migrating any artifact under \`truth/\` — the DSL migration is separate tasks.
- Restoring the speconaut recipes into the \`just check\` aggregate; that lands once the tree validates.
- Regenerating \`.speconaut/state.lock\`.

== Files

- \`.speconaut/config.toml\`
