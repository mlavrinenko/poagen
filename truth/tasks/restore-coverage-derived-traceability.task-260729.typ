#import "@local/mindtape:0.2.0": *

#show: task.with(
  title: "Restore spec-to-source traceability through the coverage-derived path",
  tags: ("speconaut", "traceability", "regression"),
  priority: 5,
  difficulty: 5,
  status: wip(2026, 8, 2),
)

== Summary

paogen's specs used to carry hand-authored \`traces: (...)\` tuples naming the source files each feature and scenario exercised — 54 of them: 28 in the model generator spec, 15 in the operation generator, 7 in the CLI, 4 in the profile. The old \`.speconaut/config.toml\` fed them through a \`\[traces\] source-dirs\` key.

Current speconaut removed the parameter from the DSL entirely. \`feature()\` and \`scenario()\` no longer accept \`traces:\`, and nothing in \`lib/spec.typ\` mentions it. Traceability is coverage-derived now: the test adapter reports which source lines each scenario actually executed, and \`speconaut audit-traces\` compares that against what was declared. That is a strictly better mechanism — a declared trace is a claim, a coverage-derived one is a measurement.

The migration therefore had to delete all 54 rather than relocate them, because there is nowhere to put them. They are preserved in git at commit \`d879084\` if any turn out to be worth consulting.

The regression is that the replacement is not wired up. Coverage-derived traces need the PHPUnit adapter pipeline running, and that pipeline is broken — the Justfile still invokes the removed \`speconaut interop extract\` subcommand. So between the migration and this task, paogen has no spec-to-source traceability of either kind.

== Acceptance criteria

- The PHPUnit adapter pipeline runs: \`speconaut generate-tests --adapter phpunit\` produces stubs, the suite runs with coverage, and \`speconaut audit-traces\` compares reported coverage against declarations without erroring.
- Every scenario that exercises source code resolves to at least one traced file, or is explicitly accounted for as plumbing in the \`\[audit-traces\]\` config with a reason.
- A source file under a configured source root with no scenario covering it is reported. Whether that is an error or a warning is a decision this task makes and records.
- The result is wired into a Justfile recipe and, if it is stable enough, into \`just check\`.
- Spot-check against the deleted declarations at \`d879084\`: any file a human had declared that coverage does not confirm is investigated, since that gap is either a missing test or a stale claim, and both are worth knowing.

== Non-goals

- Reintroducing hand-authored traces. The DSL no longer supports them and the measurement is better than the claim.
- Fixing the Justfile's broken subcommand invocation, which \`rewire-speconaut-justfile-recipes\` owns. This task depends on that landing first.
- Raising test coverage. This measures what traceability exists; closing gaps it reveals is separate work.

== Files

- \`Justfile\`
- \`.speconaut/config.toml\`
- \`tests/generated/\`
