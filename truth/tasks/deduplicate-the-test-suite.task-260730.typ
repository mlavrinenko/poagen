#import "@local/mindtape:0.2.0": *

#show: task.with(
  title: "Remove the duplication the gate finds in the test suite",
  tags: ("testing", "quality"),
  priority: 5,
  difficulty: 4,
  status: done(2026, 8, 1),
  links: depends-on("adopt-jscpd-duplication-gate.task-260730.typ"),
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

== Result

Starting point, measured after the import-block markers had landed — the figure
this task asked for before any work:

#table(
  columns: 3,
  [], [*Before*], [*After*],
  [source tier (`lint-jscpd`'s path set)],
  [96 clones, 5.13% lines],
  [76 clones, 3.36% lines],

  [`tests/` alone], [54 clones, 6.20% lines], [34 clones, 2.94% lines],
  [hand-written to hand-written clone pairs], [30], [10],
  [tests, assertions], [217, 1198], [217, 1198],
)

The 14.05% the summary quotes was jscpd at its defaults, before `.jscpd.json`
stopped counting file preambles. 6.20% is the same suite measured the way the
gate measures it.

What moved: nine `tests/Integration/` files that still hand-rolled their own
composer loader, scratch-directory bookkeeping and teardown went onto
`tests/Support/GeneratedTreeSandbox.php`, and two helpers were added to it —
`generator()`, which wraps the `new Generator(new AttributeScanner(...))`
construction repeated thirteen times across eleven files, and
`runGenerateCommand()`, which captures stdout and stderr around a CLI run. Net
662 lines deleted against 132 added, with no test removed and no assertion
weakened.

What did not move, deliberately. The schema constant, the `Profile(...)` literal
and every assertion stayed at the call site in all nine files — a reader still
learns which schema a test runs against and what it expects without opening the
trait, which was the condition on this work rather than a nice-to-have. Left
duplicated on purpose: the profile literals in the two CLI tests, because the
profile is what those tests are about; the "nothing written on abort" method
that repeats across two features against different schemas, because that is the
test, not its scaffolding; and `DecoratorProofTest`'s two hand-written doubles,
which are the subject under test.

Roughly 24 of the 34 clones that remain in `tests/` sit outside this task's
reach: nine between speconaut-emitted `*Steps.php` files, six between an emitted
file and a hand-written test that mirrors it, eight in or against the emitted
fixture trees, and one inside a schema fixture that feeds the byte-stability
golden tree. That share is the honest ceiling for hand deduplication here — the
rest is a generator's output, and `collapse-operations-onto-a-runtime-transport`
owns it.

The threshold is written down where the gate reads it: `lint-jscpd`'s
`--threshold` moved 5.5 to 3.5, ratcheted down to sit just above the new
measurement, with the same RATCHET wording the recipe already carried.
`lint-jscpd-generated` was not touched. `just check` passes.
