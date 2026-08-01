#import "@local/mindtape:0.2.0": *

#show: task.with(
  title: "Adopt the speconaut config surfaces paogen leaves unset",
  tags: ("speconaut",),
  priority: 4,
  difficulty: 4,
  status: done(2026, 8, 1),
)

== Summary

\`.speconaut/config.toml\` is schema-current but configures only \`\[check\]\` roots and \`\[check.code-refs\]\`. Current speconaut also reads \`\[check.headers\]\`, \`\[check.context-deps\]\`, \`\[check.orphan-review\]\`, \`\[status.staleness\]\`, \`\[tasks\]\` budget and \`\[orientation\]\`. Each one is inert while unset, so paogen is running a fraction of the checking it could — silently, since an unset surface reports nothing rather than warning that it is off.

== Acceptance criteria

- every listed surface is either configured, or declined in a comment that says why declining is right for paogen
- \`speconaut check\` and \`speconaut status\` still pass after the change
- a reader of the config can tell adopted from deliberately-declined without running anything

== Non-goals

- does not adopt \`\[session\]\` or install git hooks; session-less is this milestone's decision
- does not change the \`\[check.code-refs\]\` allowlist — \`narrow-the-code-ref-exemption\` owns that
- does not add a config surface speconaut does not actually read

== Files

- \`.speconaut/config.toml\`
- \`AGENT.md\`
