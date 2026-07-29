#import "@local/mindtape:0.2.0": *

#show: task.with(
  title: "Analyse the example generated trees, not only the test fixtures",
  tags: ("strictness", "quality-gates", "examples"),
  priority: 6,
  difficulty: 3,
  status: proposed(2026, 7, 29),
)

== Summary

\`phpstan-generated.neon\` is the consumer-view gate: it analyses generated output at max level with no baseline, no \`excludePaths\` and no \`ignoreErrors\`, exactly as a consumer running PHPStan in their own project would. It points at one path, \`tests/fixtures/generated\`.

The example trees under \`examples/\*/generated/\` are not in that path, so nothing analyses them. Those are the trees a person actually reads when deciding whether paogen produces code they would accept — \`examples/petstore/generated/\` is the shop window — and they are the least gated code in the repository. \`phpstan.neon.dist\` does not cover them either; it lists \`bin\`, \`src\` and \`tests\`.

So the project's strongest strictness claim has a hole exactly where a newcomer looks first. Committing a regenerated example tree today cannot fail the gate no matter what is in it.

== Acceptance criteria

- \`phpstan-generated.neon\` analyses every \`examples/\*/generated/\` tree alongside \`tests/fixtures/generated\`.
- It still declares no baseline, no \`excludePaths\` and no \`ignoreErrors\`. If an example tree cannot pass, the emitter is fixed — an exemption is not added.
- Any consumer-side value objects an example's profile binds are added to \`scanDirectories\`, matching how the fixture profiles are already handled.
- \`just check\` passes with the widened path, or fails with findings that are then fixed at their source in the emitters.
- Regenerating an example and committing a tree that would not pass max level fails the gate.

== Non-goals

- Widening \`phpstan.neon.dist\` to cover generated trees. The two-tier split is deliberate: the consumer view is what gates output.
- Adding examples, or un-marking any \`.expected-failure\` example. An example that does not generate has no tree to analyse.
- Changing the PHPStan level or rule sets.

== Files

- \`phpstan-generated.neon\`
- \`examples/\*/generated/\` (only if findings must be fixed at the emitter and trees are regenerated)
