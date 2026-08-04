#import "@local/speconaut:0.1.0": *
#import "../domain/generation.context.typ": *

#show: decision.with(
  title: "The generated tier's duplication ceiling is measured per tree, not once across the corpus",
  status: accepted(2026, 8, 3),
  contexts: (generation-context,),
  goals: (link("../goals/strict-clean-output.goal.typ"),),
  standards: (link("../standards/analysis-runs-at-maximum-strictness.standard-260729.typ"),),
  process-only: "governs poagen's own duplication-gate configuration for the generated tier — what `just lint-jscpd-generated` measures and `scripts/jscpd-generated-baselines` records — not what the generator produces or what a reimplementation must do",
)

== Context

`adopt-jscpd-duplication-gate` (`adopt-jscpd-duplication-gate.task-260730.typ`)
scaffolded jscpd as two report-only tiers, one over hand-written code and
one over emitted output. `jscpd-as-a-real-gate` turned both into failing
gates on 2026-08-01. The generated tier's failing threshold was one number
across every emitted tree.

That shape stopped working on 2026-08-03. Every emitted client carries a
byte-identical `ApiException.php`, and `examples/petstore/generated` emits
the same document `tests/fixtures/generated/petstore` already does —
cross-tree artefacts no emitter change removes. Committing a new golden
tree raised the corpus figure by existing alone, and two tasks paid for
it: `close-the-three-sites-that-widen-a-declared-shape` and
`additional-properties-become-a-typed-bag` both dropped a golden tree
rather than touch the ratchet, leaving the shapes they introduced with no
generated-tier PHPStan analysis at all — the one tier this project holds
to no baseline, no `excludePaths` and no `ignoreErrors`.
`generated-tier-duplication-ratchet-blocks-new-golden-trees` is the task
that fixed it: `just lint-jscpd-generated` now runs jscpd once per emitted
tree and reads a ceiling per tree from `scripts/jscpd-generated-baselines`.
This records that outcome.

== Choice

=== Options considered

#table(
  columns: (auto, 1fr),
  [*Option*], [*Why, or why not*],
  [One threshold across all four `examples/*/generated` trees],
  [The status quo this replaces. A single number is a ceiling on the worst
   tree, so every smaller tree carries slack nothing is watching, and the
   ceiling moves for a reason unrelated to duplication — a new tree
   existing at all.],

  [A threshold per tree],
  [Chosen. Ties the ceiling to the property that actually varies between
   trees. `scripts/jscpd-generated-baselines` states, per tree, what was
   measured and why; a new tree adds a row rather than moving anyone
   else's ceiling.],

  [Drop the generated tier's duplication gate entirely],
  [Removes the only instrument watching for a regression of
   `collapse-operations-onto-a-runtime-transport`'s fix — an emitter that
   abandons `runtime/` and inlines request assembly per operation.
   `generated-tier-duplication-ratchet-blocks-new-golden-trees` re-verified
   the gate still catches that shape after the per-tree change, by
   planting it on scratch copies of two trees; dropping the gate means
   nothing catches it at all.],
)

=== Why per tree, in one line

One number across four trees measures how big a vendor's document is, not
how duplicated the generator's output is, and the largest tree sets the
ceiling for every other — a corpus figure can only ever be as tight as its
biggest document allows. `scripts/jscpd-generated-baselines` carries the
measurements this reasoning rests on: the percentage per tree, what each
tree's clones actually are, and the planted-regression proof the gate
still catches what it exists to catch. Read the numbers there; a figure
copied into this decision would go stale the next time a tree is measured
again.

=== Scope: `examples/*/generated` only

Only `examples/*/generated` trees get their own row in
`scripts/jscpd-generated-baselines`. `tests/fixtures/generated/*` stays
under one uniform ceiling inside the same recipe — those are poagen's own
fixtures, small and hand-made, not emitted from a real vendor document
whose scale sets its own floor. A new fixture tree there adds no row and
needs none.

=== Ratchet direction

Every ceiling in `scripts/jscpd-generated-baselines` only ever moves down,
as real duplication inside that one tree is collapsed further. A tree
gaining operations, models, or anything else that grows its document is
never a reason to raise its ceiling — the ceiling answers "how duplicated
is this tree", and a bigger tree is not automatically a more duplicated
one. Regenerating a tree against a newer revision of its vendor document
can legitimately move its floor, recorded in the same commit as the new
measurement and which document revision moved it.

=== A fifth tree

`just lint-jscpd-generated` refuses to pass an `examples/*/generated` tree
that has no row in `scripts/jscpd-generated-baselines` — a hard failure
naming the tree, not a silent pass at whatever jscpd happens to measure
unwatched. The recipe treats a row naming a tree that no longer exists the
same way, so a baseline can never quietly outlive what it gates. A fifth
example tree gets the same treatment the first four did: measured, and
given its own row with the reasoning this decision describes, before it
can pass.

== Consequences

- `quality-gates-at-maximum-strictness` is narrowed for one tier, not
  replaced. This governs the generated tier's duplication ceiling only.
  `just lint-jscpd` — `src/`, `runtime/src/`, `tests/` and
  `examples/*/src` together — keeps its single threshold, unaffected by
  anything here.
- A reader who finds four different numbers in
  `scripts/jscpd-generated-baselines` where an earlier decision or comment
  describes one is reading a deliberate, recorded change, not a gate
  someone loosened to get a build green.
- Adding a fifth `examples/*/generated` tree requires a measured row in
  `scripts/jscpd-generated-baselines` before `just lint-jscpd-generated`
  passes; there is no default ceiling a new tree inherits.
- Nothing here changes any ceiling, the hand-written tier's threshold, or
  whether the generated tier is duplication-gated at all — this records
  what already shipped.
