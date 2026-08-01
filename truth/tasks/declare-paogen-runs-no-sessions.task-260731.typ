#import "@local/mindtape:0.2.0": *

#show: task.with(
  title: "Declare that paogen does not run speconaut sessions",
  tags: ("speconaut",),
  priority: 6,
  difficulty: 1,
  status: done(2026, 8, 1),
)

== Summary

\`speconaut check\` emits 31 \`task lifecycle provenance\` warnings against paogen, each saying a \`done\` task has no session block recording its slug and that "the lifecycle may have been bypassed". paogen declined the session workflow deliberately, so the warnings are permanent and unactionable — and they sit in the same output channel as findings that matter.

speconaut now has a \`\[session\] enabled\` key for exactly this. Setting it to \`false\` says the project opted out, and the provenance check goes inert instead of complaining about a workflow nobody chose.

Verified end to end on a throwaway copy of paogen with that one line added: \`All specs valid (4 features)\`, zero warnings.

== Acceptance criteria

- \`.speconaut/config.toml\` declares \`\[session\] enabled = false\` with a comment saying why paogen opted out
- \`speconaut check truth/\` emits zero \`task lifecycle provenance\` warnings
- the comment says what would have to change for sessions to be worth adopting, so the decision can be revisited rather than merely inherited

== Non-goals

- does not adopt the session workflow or install git hooks
- does not touch any other config surface
- blocked until the \`\[session\] enabled\` key ships in the speconaut on PATH; setting it earlier fails config load, which rejects unknown fields

== Files

- \`.speconaut/config.toml\`
