#import "@local/mindtape:0.2.0": *

#show: task.with(
  title: "Make the decisions audit a repeatable command instead of an improvisation",
  tags: ("process", "mindtape"),
  priority: 7,
  difficulty: 5,
  status: proposed(2026, 8, 1),
)

== Summary

The human review gate was removed because thirty-eight tasks reached it and none left. What actually worked in its place, on 2026-08-01, was two audits run over already-closed work:

One took fourteen tasks and checked each acceptance criterion against the tree, returning met / not-met / needs-judgment with evidence. It found four criteria that overshot what had landed, one of them a live defect the gate could not see.

The other took twenty-four tasks and extracted only the decisions — a choice made in passing without an artifact, a convention now binding, a spec bent to match code, a threshold set by fiat — ranked by consequence. The owner read the ranked list and ruled on all of it in one sitting.

Both were improvised. Neither is in the repository, so neither can be run again, and the next backlog gets whatever the next session happens to think of.

The distinction that made the second one usable is the one to preserve: the owner does not want to review code, and cannot review a thousand files. He wants to review decisions. An audit that returns diffs has failed no matter how thorough it is.

== Acceptance criteria

- A command runs the audit over a set of tasks selected by filter, so \`\@recent\` or any other view can be its input.
- It returns decisions, not diffs: a choice between defensible alternatives, a convention that now binds future work, an artifact contradicting another, a threshold or exemption set without recorded rationale, a spec weakened rather than corrected.
- Findings are ranked by consequence, and each carries what was decided, what the alternatives were, and who it binds — enough to rule on in one reading.
- A task that settled nothing produces one honest line saying so. Padding a report to look thorough is the failure mode that makes an audit unreadable.
- It states plainly what it cannot check, rather than reporting a judgment call as a verified fact.
- The output distinguishes findings needing the owner's input from those an implementer may accept, so a reading can stop early.
- Running it over the 2026-08-01 backlog reproduces the substance of what the improvised audits found. If it misses the pre-transport spec drift, it is not finished.

== Non-goals

- Reinstating a status a task must pass through before closing. That was decided against and recorded; this audit reads after the fact.
- Gating anything. It informs a human, it does not block a flip — the flip predicate is separate work.
- Reviewing code quality, style, or test coverage. Other instruments own those, and mixing them in is what made review unusable before.

== Files

- \`.mindtape/config.toml\`
- \`Justfile\`
- \`AGENT.md\`
- \`truth/decisions/\`
