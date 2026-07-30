#import "@local/mindtape:0.2.0": *

#show: task.with(
  title: "A sub-client scenario still asserts the pre-transport constructor",
  tags: ("speconaut",),
  priority: 7,
  difficulty: 3,
  status: status(
    "needs-review",
    2026,
    7,
    31,
    note: [landed this session; verified on the merged head by the orchestrator],
  ),
)

== Summary

\`truth/specs/operation-generator.feature-260418.typ:341\` holds the scenario "A sub-client is constructible without the root", whose Then reads:

> the Client's constructor takes the PSR-18 client, the PSR-17 factories, the base URI, any declared credential and the hydration collaborators — and never the root Client

That is the constructor \`collapse-operations-onto-a-runtime-transport\` replaced. Emitted sub-clients now take a \`TransportInterface\` and whatever credential the schema declares — two parameters where the scenario names seven. The scenario is \`unstable\`, so it is lockable and counts toward standards coverage, and it asserts a contract the generator no longer honours.

Surfaced while giving the standards a testable obligation: this was the one candidate scenario for \`caller-surface-is-injectable\`, and citing it would have tied a standard to a false statement.

== Acceptance criteria

- the scenario asserts the constructor the generator actually emits
- whatever asserts it in \`tests/generated/OperationGeneratorSteps.php\` is checked against the current shape too, and either agrees or is corrected
- a search of the four feature files turns up no other scenario still describing the pre-transport surface; say in the report what was searched for and what was found

== Non-goals

- does not change the emitter; the code is right and the spec is stale
- does not restage any scenario
- does not touch the standards' \`structural:\` text, which was written against the real enforcers

== Files

- TODO: paths this task expects to change
