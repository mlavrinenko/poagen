#import "@local/mindtape:0.2.0": *

#show: task.with(
  title: "Migrate the ten ADRs from adr() to the decision() artifact",
  tags: ("speconaut",),
  priority: 7,
  difficulty: 5,
  status: proposed(2026, 7, 28),
)

== Summary

The \`adr()\` DSL function no longer exists in speconaut's library; it was replaced by \`decision()\`, which drops the \`number:\` slot, takes its status as a dated call rather than a bare identifier plus a separate \`date:\`, and adds \`contexts:\`, \`goals:\`, \`standards:\`, \`supersedes:\` and \`process-only:\` slots. paogen has ten decision files, all in the retired shape, all named \`NNN-slug.typ\` rather than the \`.decision-\<yymmdd>.typ\` form the current classifier requires.

== Acceptance criteria

- All ten files use \`decision.with(...)\` and carry the \`.decision-\<yymmdd>.typ\` sub-extension, dated from the decision's own date.
- Status is the dated call form.
- ADR-007's superseded representation section uses the \`supersedes:\` / superseded relationship the DSL provides rather than prose alone.
- Every accepted decision cites at least one goal, and either a standard or a process-only reason, satisfying speconaut's own standard on the subject.
- Cross-references from README, ROADMAP and the spec files resolve to the new filenames.

== Non-goals

- Revisiting any decision's substance; this is a format migration.
- Writing the standards library itself — that is a separate task this one depends on.
- Renumbering or merging decisions.

== Files

- \`truth/decisions/\*.typ\`
- \`truth/main.typ\`
- \`README.md\`
- \`ROADMAP.md\`
