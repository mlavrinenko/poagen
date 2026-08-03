#import "@local/mindtape:0.2.0": *

#show: task.with(
  title: "record the per tree duplication ceilings",
  tags: ("truth", "decision", "gates"),
  priority: 5,
  difficulty: 2,
  status: accepted(
    2026,
    8,
    3,
  )[Owed since the duplication tier moved from one corpus-wide threshold to a ceiling per emitted tree on 2026-08-03. The reasoning is written in full; it is the artifact that is missing.],
)

== Summary

`adopt-jscpd-duplication-gate` and `quality-gates-at-maximum-strictness` both
describe a duplication gate with one threshold that only ever moves down. The
generated tier stopped working that way on 2026-08-03: `just
lint-jscpd-generated` now runs jscpd once per emitted tree and reads a ceiling
per tree from `scripts/jscpd-generated-baselines`.

The change is right and the reasoning is already written, at length, in that
file's header — measured figures (petstore 0.00%, kilbil 1.67%, DigitalOcean
6.27%, GitHub 20.65%), what the two large trees' clones actually are (transport
delegation on DigitalOcean; one repository shape the document declares under
five names on GitHub), why neither is duplicated logic, and the planted-
regression proof that the gate still catches the thing it exists to catch.

What is missing is the artifact. A ratchet whose value differs per tree is a
different gate from a ratchet with one number, and a reader who finds four
numbers where the decisions describe one has no way to tell a deliberate change
from a gate somebody loosened to get a build green.

The artifact should cite `scripts/jscpd-generated-baselines` rather than restate
it. That file is where a reader raising or lowering a ceiling will actually be
standing, the reasoning has to stay next to the numbers to be read at all, and
`code-references-permitted-in-generator-specs` — as
`code-refs-blind-to-bare-basenames` is about to widen it — permits naming it.

== Acceptance criteria

- A decision artifact records the per-tree ceiling for the generated tier, with
  its options and consequences, citing at least one goal and one standard.
- The options it weighs include at minimum: one threshold across all four
  trees; a threshold per tree; and dropping the generated tier's duplication
  gate entirely.
- It states the load-bearing reason in its own words — one number across four
  trees measures how big a vendor's document is, and the largest tree sets the
  ceiling for every other — and cites
  `scripts/jscpd-generated-baselines` for the measurements rather than copying
  them, since a copied figure is a figure that goes stale silently.
- It states the ratchet direction that still holds: a per-tree ceiling only
  ever moves down, and a tree that gains operations is not a reason to raise
  one.
- It says what happens when a fifth example tree is added — which is the case
  the format has to survive and the one a reader will hit next.
- The relationship to `adopt-jscpd-duplication-gate` is explicit: this narrows
  the generated tier only, and `src/` plus `runtime/src/` keep their single
  threshold.
- `speconaut check truth/` is green and `just check` passes.

== Non-goals

- Changing any ceiling, or the recipe that reads them. This records what
  shipped.
- The hand-written tier's threshold in `just lint-jscpd`, which is unchanged
  and stays one number.
- Re-opening whether generated output should be duplication-gated at all.

== Files

- `truth/decisions/` (a new decision artifact)
- `scripts/jscpd-generated-baselines` (a pointer back to the artifact, if the
  header does not already have somewhere obvious to put one)
