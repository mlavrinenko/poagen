#import "@local/mindtape:0.2.0": *

#show: task.with(
  title: "Reword the architecture so the four-context split stops contradicting its task",
  tags: ("truth", "domain", "docs"),
  priority: 5,
  difficulty: 3,
  status: proposed(2026, 8, 1),
)

== Summary

\`migrate-domain-to-context\`'s own Non-goals section said splitting the vocabulary into several bounded contexts was out of scope: "one context is correct at this size." What landed, in the same task, is four — \`truth/domain/schema.context.typ\` (functional, 2 entities), \`truth/domain/guidance.context.typ\` (functional, 5), \`truth/domain/generation.context.typ\` (technical, 5), \`truth/domain/cli.context.typ\` (technical, 1) — decided inside the implementing commit rather than in the task that authorised the work.

The split itself is not the problem. What the vendor publishes, what the consumer writes, what paogen emits, and what gets run are four genuinely different concerns, and every accepted decision and standard since has cited these four contexts by name — unwinding the split now costs as many edits as the commit warned splitting later would. The problem is narrower: the task record says one thing happened and a different thing landed, with the reversal argued only in a commit message, and no artifact reconciles the two so a future reader hits the same contradiction \`migrate-domain-to-context\` did.

This is a documentation reconciliation, not a re-split. The four contexts stay exactly as they are — same files, same entity groupings, same functional/technical labelling. What needs to change is the record: the non-goal that no longer describes what happened, and the absence of anywhere that argues why four contexts is right at this size rather than merely what was convenient mid-migration.

== Acceptance criteria

- \`migrate-domain-to-context.task-260728.typ\`'s Non-goals section no longer asserts "one context is correct at this size" as a stated boundary of a task whose own Result shows four; the task record is corrected to reflect what actually landed and why, rather than left self-contradicting.
- Somewhere reachable from the domain tree — a short note in \`truth/domain/\`, or a decision artifact if the reasoning is substantial enough to bind future changes — the four-context split is argued on its own terms: what each context owns, why splitting along vendor/consumer/generator/runner lines is right at paogen's current size, and what would justify collapsing or further splitting it later.
- Nothing in \`truth/domain/\` or the task record claims a single-context model was ever shipped or is still the plan.
- \`speconaut check truth/\` and the \`\[check.context-deps\]\` findings enumerated in \`.speconaut/config.toml\` are unaffected by the wording change — this task edits prose, not \`contexts:\` declarations or entity ownership.

== Non-goals

- Does not re-split, merge, or rename any bounded context, entity, or \`.context.typ\` file.
- Does not resolve the twelve \`\[check.context-deps\]\` findings \`.speconaut/config.toml\` defers — that ownership question is separate from whether the split's existence is honestly recorded.
- Does not add typed \`props\` to any entity; \`typed-domain-entity-props\` owns that.
- Does not reopen whether entities should carry real data, which \`migrate-domain-to-context\` already decided against under the same non-goal this task is correcting only the context-count half of.

== Files

- \`truth/tasks/migrate-domain-to-context.task-260728.typ\`
- \`truth/domain/schema.context.typ\`
- \`truth/domain/guidance.context.typ\`
- \`truth/domain/generation.context.typ\`
- \`truth/domain/cli.context.typ\`
- \`truth/decisions/\` (only if the reasoning warrants a standing artifact rather than a domain-tree note)
