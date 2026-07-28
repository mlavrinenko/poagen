#import "@local/mindtape:0.2.0": *

#show: task.with(
  title: "Decide the code-reference policy for a code generator's specs",
  tags: ("speconaut",),
  priority: 6,
  difficulty: 6,
  status: proposed(2026, 7, 28),
)

== Summary

speconaut forbids file paths, module paths and function calls in specs, decisions, standards and domain artifacts, on the principle that those layers stay implementation-agnostic and portable. paogen's truth tree contains roughly 460 such references, concentrated in the specs (about 410) and in the ADR covering attribute and phpdoc driven serialisation (about 30). For a code generator this is not obviously drift: the emitted PHP is the observable behaviour, so a scenario asserting the exact emitted expression is a behavioural assertion, not an implementation leak. The project needs a recorded decision either way before the check can be turned on.

== Acceptance criteria

- A decision artifact records the policy, citing the goals it serves.
- If references stay, the config allowlist enumerates the permitted shapes and the reasoning is in the decision, not only in a comment.
- If references go, the affected scenarios are rewritten to assert emitted behaviour through the domain vocabulary instead, and the count drops to zero.
- \`speconaut check\` reports no unresolved code-reference findings under the chosen policy.

== Non-goals

- Silently widening the allowlist to whatever makes the check pass; the point is the recorded rationale.
- Changing what the scenarios assert about generator behaviour.

== Files

- \`truth/decisions/\`
- \`truth/specs/\*.typ\`
- \`.speconaut/config.toml\`
