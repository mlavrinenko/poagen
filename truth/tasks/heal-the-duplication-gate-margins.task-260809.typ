#import "@local/mindtape:0.2.0": *

#show: task.with(
  title: "Heal the duplication gate margins",
  tags: ("gates",),
  priority: 3,
  difficulty: 5,
  status: proposed(2026, 8, 9),
  links: (
    related("retighten-the-generated-duplication-ceilings.task-260804.typ"),
    related("adopt-jscpd-duplication-gate.task-260730.typ"),
  ),
)

== Summary

Both duplication tiers pass today with no room left, and one of them has
literally none. Measured 2026-08-09 at `61857d80`:

- source tier (`lint-jscpd`): 2.99% against a 3.0 ratchet — 0.01 points, and
  the last two commits spent most of it. 154 clones over 414 files; the php
  row alone reads 3.18%.
- generated tier (`lint-jscpd-generated`): `examples/kilbil/generated` 1.42%
  against a 1.42 ceiling, `examples/digitalocean/generated` 10.92% against
  10.92, `examples/github/generated` 22.31% against 22.31. Three trees at
  exactly zero slack, because `--threshold` fails on `>` and those ceilings
  were recorded as the measured figure rounded to two places.
  `examples/petstore/generated` has 0.01.

A ratchet with no margin is not a ratchet, it is a tripwire: the next
regeneration that adds one duplicated line turns a gate red for a reason
nobody chose, and the pressure at that moment is to raise the number — the
one thing every RATCHET paragraph in this repo forbids. The margin has to
come from removing duplication, or the zero has to be a deliberate, recorded
choice rather than an artifact of how the ceilings were rounded.

Second, smaller problem, same gate: the recipes print jscpd's own
`Found 154 clones.` / `Found 4 clones.` line and nothing about what was
gated. That line is informational — the gate is the percentage against the
threshold, and the Justfile comment already says why `--exit-code` must not
be added — but a reader watching `just check` scroll past "Found 4 clones."
on an exit-0 run cannot tell a pass from a gate that failed open.

Third: the source tier's figure has never been separated into duplicated
logic and repeated scaffolding. `.jscpd.json` already strips `declare`,
`namespace` and top-level `use`, on exactly that reasoning, but a test file's
setup preamble is the same kind of repeated text and is still counted. Until
someone measures how much of the 3.18% php row is that, "we are 0.01 from the
limit" is a number without a meaning.

== Acceptance criteria

- Every tier's margin is stated with a fresh measurement, and each is either
  restored to slack that survives an ordinary commit, or recorded — in a
  decision artifact, not a comment nobody re-reads — as deliberately zero with
  the reason it cannot be otherwise.
- The source tier's figure is split by measurement into duplicated logic and
  repeated scaffolding, naming the clones on each side. Whatever is
  scaffolding is either factored out or covered by an `ignorePattern` whose
  justification is written in the same terms `.jscpd.json`'s existing
  patterns are.
- Both recipes print, per scan, the measured figure against the ceiling they
  gated on, so an exit-0 run reading "Found N clones." is unambiguous.
- Any ceiling that moves, moves DOWN. A ceiling that cannot fall carries a
  written reason naming the clones that hold it up.
- `scripts/jscpd-generated-baselines` and the Justfile comments state what the
  tree measures today, not what it measured in July. Every stale figure they
  still carry is re-measured or deleted.
- `just check` and `just check-examples` green end-to-end.

== Non-goals

- Raising any threshold to admit a clone. The margin comes from the tree, not
  from the number.
- An `ignorePattern` that hides genuine duplicated logic. Preamble and
  scaffolding only, argued case by case.
- Changing what the generated tier measures. It stays per-tree rather than
  per-corpus; that reading is settled and its reasoning is in the recipe.
- Switching duplication tools.

== Files

- `Justfile`, the `lint-jscpd` and `lint-jscpd-generated` recipes
- `.jscpd.json`
- `.jscpd.generated.json`
- `scripts/jscpd-generated-baselines`
- `tests/`
- `truth/decisions/`
