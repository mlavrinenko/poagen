#import "@local/mindtape:0.2.0": *

#show: task.with(
  title: "Give the three uncovered standards a testable obligation",
  tags: ("speconaut",),
  priority: 5,
  difficulty: 4,
  status: status(
    "needs-review",
    2026,
    7,
    31,
    note: [landed this session; verified on the merged head by the orchestrator],
  ),
)

== Summary

\`speconaut check\` warns on three accepted standards that declare no testable obligation — no \`\#v(...)\` rule value, no \`requires-cases:\`, no \`structural:\` opt-out:

- \`caller-surface-is-injectable\`
- \`guidance-is-data-not-code\`
- \`silence-means-success\`

Each would report \`realized\` with no citing scenario. A standard nothing cites is a rule the project believes it follows and cannot show.

== Acceptance criteria

- \`speconaut check truth/\` emits zero standards-coverage warnings
- each of the three carries either a \`\#v(...)\` rule value exercised by an \`unstable\` scenario, a \`requires-cases:\` entry with a matching \`case:\` scenario, or a \`structural:\` reason naming where enforcement actually lives
- no scenario was bent to fit a standard it does not really exercise

== Non-goals

- does not touch the other four standards
- does not add scenarios beyond what a cited case honestly needs
- does not restage any scenario

== Files

- \`truth/standards/caller-surface-is-injectable.standard-260729.typ\`
- \`truth/standards/guidance-is-data-not-code.standard-260729.typ\`
- \`truth/standards/silence-means-success.standard-260729.typ\`
- \`truth/specs/\*.feature-\*.typ\`
