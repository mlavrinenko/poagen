#import "@local/mindtape:0.2.0": *

#show: task.with(
  title: "Opt-in collapse for repeated response maps",
  tags: ("generator", "gates"),
  priority: 2,
  difficulty: 7,
  status: done(2026, 8, 9),
  links: (
    related("heal-the-duplication-gate-margins.task-260809.typ"),
    related("retighten-the-generated-duplication-ceilings.task-260804.typ"),
  ),
)

== Summary

Three emitted trees pass the generated duplication tier at exactly their
ceiling — `examples/digitalocean/generated` 10.92 against 10.92,
`examples/github/generated` 22.31 against 22.31, `examples/kilbil/generated`
1.42 against 1.42. `--threshold` fails on `>`, so they pass by equality and
one duplicated line turns them red. That is now visible on every run: the
recipes print the margin (`heal-the-duplication-gate-margins`).

Two decisions have now examined why those figures cannot fall and reached the
same answer — `duplication-ceilings-follow-regeneration-not-collapse`
(2026-08-08) and `generated-tier-ceilings-cannot-fall-further` (2026-08-09).
Both name exactly one lever that would buy real margin: an opt-in collapse of
the `StatusResponseMap` declarations that repeat, identically, across
operations and across sub-client classes. The per-class helper already
weighed and deferred does not reach it, because the majority of every tree's
client-to-client clones — and all of its model-to-model clones — are
cross-file.

Both decisions declined to file that work, each on the reasonable ground that
it sat outside its own boundary. Naming a lever twice and filing it neither
time is how a temporary state becomes the permanent one: this repo's own
`retighten-the-generated-duplication-ceilings` exists because a deliberate
loosening was about to become permanent by nobody revisiting it. This task is
the revisit.

The constraint that makes this hard is settled and must be respected. The
owner ruled on 2026-08-02, on inline models, that structural identity is not
identity of meaning — two endpoints returning the same shape are not
returning the same thing, so a shape-matching heuristic may not merge them.
Anything here therefore has to be an explicit, consumer-facing opt-in in
which the consumer names the call sites they mean to be the same. That is a
profile surface and a generator change, not a deduplication pass.

== Acceptance criteria

- A consumer can name a set of operations whose response map is one shared
  declaration, and the emitter emits it once. What is shared is stated by the
  consumer, never inferred from shape — a document where two unrelated
  operations happen to declare identical responses emits them separately
  unless the profile says otherwise.
- Not naming anything changes nothing: every existing golden tree is
  byte-identical with no profile entry added, so the feature costs a
  consumer who does not want it exactly nothing.
- A profile that names an operation the document does not carry, or names
  operations whose response maps are not in fact identical, fails before the
  document is read and says which entry was wrong — the shape every other
  profile validator in this repo already follows.
- Measured effect is reported per tree, before and after, for all five
  measured trees. If the mechanism lands and the ceilings still cannot fall,
  that is a legitimate outcome and the ceilings are recorded a third time —
  but with a number behind it, not a projection.
- Any ceiling that moves, moves DOWN, and
  `scripts/jscpd-generated-baselines` carries the new measurement.
- `just check`, `just check-examples` and `just verify-runtime-standalone`
  green end-to-end.

== Non-goals

- Merging on structural identity, in any form, anywhere. That is the ruling
  this task is built around, not a constraint to be negotiated.
- Touching the source tier. It has 0.37 points of slack after
  `heal-the-duplication-gate-margins` and is not what this is about.
- Raising a ceiling, adding an `ignorePattern`, or excluding a tree. The
  standing RATCHET paragraphs apply here as everywhere else.
- Changing what the generated tier measures. Per-tree, not per-corpus; that
  reading is settled.

== Files

- `src/Generator/Profile.php`
- `src/Generator/Emit/ResponseTypeEmitter.php`
- `src/Generator/Emit/`
- `runtime/src/Contract/StatusResponseMap.php`
- `scripts/jscpd-generated-baselines`
- `truth/decisions/`
