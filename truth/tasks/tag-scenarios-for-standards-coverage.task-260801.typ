#import "@local/mindtape:0.2.0": *

#show: task.with(
  title: "Tag the scenarios that discharge two standards' coverage obligations",
  tags: ("truth", "specs", "standards"),
  priority: 6,
  difficulty: 3,
  status: proposed(2026, 8, 1),
)

== Summary

\`standards-need-testable-obligations\` moved the \`nameNormaliser\` carve-out out of an enforcement slot and into the rule where readers see it. The other half of that task — giving \`caller-surface-is-injectable\` and \`guidance-is-data-not-code\` a coverage obligation something can check — could not land with it.

speconaut's standards-coverage check only counts an obligation as discharged when a scenario in \`truth/specs/\` carries a matching \`case:\` and a \`standards:\` link back. So a \`requires-cases:\` slot on the standard is inert on its own; the scenario has to be tagged too, and \`truth/specs/\` was held by another agent at the time.

No new scenario is needed. Four scenarios already assert exactly the right behaviour and simply are not tagged.

== Acceptance criteria

- \`caller-surface-is-injectable\` gains \`requires-cases: ("sub-client-interface-omits-constructor", "sub-client-injects-transport-not-root")\`, and the two matching scenarios in \`truth/specs/operation-generator.feature-260418.typ\` — the one where each tag becomes a sub-client behind an interface, and the one where a sub-client is constructible without the root — carry those \`case:\` values plus a \`standards:\` link back to it.
- \`guidance-is-data-not-code\` gains \`requires-cases: ("default-pipeline-runs-without-guidance", "name-normaliser-shapes-identifiers-only")\`, and the two matching scenarios in \`truth/specs/model-generator.feature-260418.typ\` — the kebab-case component becoming a PascalCase class under the default pipeline, and the pattern-gated strategy falling through on a non-match — carry those \`case:\` values and the link.
- \`speconaut check truth/\` reports zero standards-coverage warnings, and the two standards keep their existing \`structural:\` slots rather than trading one for the other.
- Removing any one tag makes the coverage check complain, demonstrated rather than asserted. An obligation nothing would notice the absence of is not an obligation.
- \`speconaut lock --check\` is re-locked if tagging touches an unstable scenario.

== Non-goals

- Writing new scenarios. All four already exist and assert the right thing; this task only tags them.
- Changing what any scenario asserts.
- Widening \`\[check.code-refs\] source-extensions\`, which was investigated and deliberately left empty: setting it to \`php\` would flag every legitimate emitted-output filename the specs name as a forbidden code reference.

== Files

- \`truth/standards/caller-surface-is-injectable.standard-260729.typ\`
- \`truth/standards/guidance-is-data-not-code.standard-260729.typ\`
- \`truth/specs/operation-generator.feature-260418.typ\`
- \`truth/specs/model-generator.feature-260418.typ\`
- \`.speconaut/state.lock\`
