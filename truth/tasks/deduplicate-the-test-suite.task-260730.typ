#import "@local/mindtape:0.2.0": *

#show: task.with(
  title: "Remove the duplication the gate finds in the test suite",
  tags: ("testing", "quality"),
  priority: 5,
  difficulty: 4,
  status: proposed(2026, 7, 30),
)

== Summary

jscpd 5.0.11 at its defaults finds 91 clones and 14.05% duplicated lines across \`tests/\`. That is the second-largest concentration in the repository after the emitted trees.

Some of it will be the same import-block noise that inflates the \`src/\` figure, and \`adopt-jscpd-duplication-gate\` deals with that by wrapping headers in ignore markers. What remains is real: repeated schema-fixture setup, repeated generator construction, repeated assertions over emitted source.

Explicitness in a test is worth paying for, and a shared helper that hides which schema a test runs against makes failures harder to read rather than easier. So the target is not zero. The target is that what remains is duplication a reader would defend, and that the number stops drifting upward.

== Acceptance criteria

- The measured jscpd figure for \`tests/\` after the import-block markers land is recorded here as the starting point.
- Duplication that is setup scaffolding rather than the subject of a test is extracted, and the extraction keeps the schema, the profile and the expectation visible at the call site.
- No test loses the ability to say what it is testing without the reader opening a helper.
- Every test still passes and coverage does not fall.
- The tests tier of the jscpd gate is below its configured threshold, and the threshold is written down.

== Non-goals

- Rewriting tests onto a different assertion style or test framework.
- \`tests/generated/\`, which is tool-owned output and never hand-edited.
- The emitted-tree duplication, which \`collapse-operations-onto-a-runtime-transport\` owns.

== Files

- \`tests/Unit/\`
- \`tests/Integration/\`
- \`tests/fixtures/\`
