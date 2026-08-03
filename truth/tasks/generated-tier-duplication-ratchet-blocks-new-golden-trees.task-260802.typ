#import "@local/mindtape:0.2.0": *

#show: task.with(
  title: "generated tier duplication ratchet blocks new golden trees",
  tags: ("tooling", "gates"),
  priority: 6,
  difficulty: 4,
  status: proposed(2026, 8, 2),
)

== Summary

A new golden fixture tree cannot be committed, because adding one raises the generated tier's jscpd duplication ratio and the ratchet only ever moves down.

Measured while closing close-the-three-sites-that-widen-a-declared-shape: committing one golden tree for the widened-shapes fixture moved the generated tier from 16.01 percent to 16.71 percent against a 16.5 percent threshold. The cause is structural, not a property of that tree. Every emitted tree carries a byte-identical 73-line ApiException.php, so any new golden tree raises the ratio no matter what it contains.

The agent dropped its golden rather than touch the ratchet, which is the right call under the rules as written and the wrong outcome: the emitted shapes that task introduced now get no generated-tier PHPStan analysis at all, and the generated tier is the one held to no baseline, no excludePaths and no ignoreErrors. So the check that matters most for emitted output is the one a new fixture cannot reach.

Anyone who adds a golden tree next hits the same wall.

=== It bit a second time the same day

`additional-properties-become-a-typed-bag` hit it too. Because no `open-shapes`
golden tree can be committed, the emitted bag code reaches no tier of the gate
at all: `lint-phpstan-generated` sees only `tests/fixtures/generated` and the
example trees, and none of them contains a bag. The agent closed the hole by
hand — generated the tree into a scratch directory and ran
`phpstan analyse -c phpstan-generated.neon` over it, exit 0 across 11 files —
and said plainly that the check is manual and will not repeat itself.

So the cost is now measured rather than predicted: every emitted shape added
from here on is unanalysed by the one tier held to no baseline, no
`excludePaths` and no `ignoreErrors`, until this lands. Two tasks have paid it.

== Acceptance criteria

- Adding a golden fixture tree no longer raises the generated tier's duplication figure by the mere fact of existing. Either the shared emitted preamble is excluded from the tier the way a file's import block already is, or the tier is measured per-tree rather than across the corpus, or the ratchet's rule gains a stated exception with a reason.
- Whatever is chosen keeps the ratchet meaningful for real duplication inside a single emitted tree. A gate loosened until it passes is not a gate.
- The golden tree dropped by close-the-three-sites-that-widen-a-declared-shape is committed, and the generated tier analyses its map-valued response types and its additional-properties attribute at max level.
- The open-shapes tree that additional-properties-become-a-typed-bag could only analyse by hand, in a scratch directory, is committed too, so that check runs on every gate rather than once.
- The threshold's comment says what the number means after this change, since the current one says it only ever moves down.

== Non-goals

- The source tier's jscpd ratchet, which is a different config and not affected.
- Relaxing the generated tier's PHPStan absolutes. This is about letting a fixture reach that analysis, not about weakening it.

== Files

- .jscpd.json or wherever the generated tier's config lives
- Justfile, recipe lint-jscpd-generated
- tests/fixtures/generated/
