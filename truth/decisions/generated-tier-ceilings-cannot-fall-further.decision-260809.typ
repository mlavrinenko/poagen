#import "@local/speconaut:0.1.0": *
#import "../domain/generation.context.typ": *

#show: decision.with(
  title: "The generated tier's four ceilings stay at their measured floor — the margin is deliberately zero, not an artifact of rounding",
  status: accepted(2026, 8, 9),
  contexts: (generation-context,),
  goals: (link("../goals/strict-clean-output.goal.typ"),),
  standards: (link("../standards/analysis-runs-at-maximum-strictness.standard-260729.typ"),),
  relates-to: (
    link("generated-duplication-ceiling-is-per-tree.decision-260803.typ"),
    link("envelope-remeasures-the-generated-duplication-floors.decision-260804.typ"),
    link("duplication-ceilings-follow-regeneration-not-collapse.decision-260808.typ"),
  ),
  process-only: "governs poagen's own duplication-gate configuration for the generated tier — what `just lint-jscpd-generated` measures and `scripts/jscpd-generated-baselines` records — not what the generator produces or what a reimplementation must do",
)

== Context

`heal-the-duplication-gate-margins` found three of the four generated-tier
trees sitting at exactly their ceiling — `examples/kilbil/generated` 1.42%
against 1.42, `examples/digitalocean/generated` 10.92% against 10.92,
`examples/github/generated` 22.31% against 22.31 — with the fourth,
`examples/petstore/generated` (and its fixture twin), a hundredth of a point
under. `--threshold` fails on `measured > threshold` strictly, so a tree
already at its ceiling passes only by equality: the next regeneration that
adds a single duplicated line turns the gate red for a reason nobody chose,
which is the tripwire this task exists to fix.

`duplication-ceilings-follow-regeneration-not-collapse` already answered the
adjacent question once, on 2026-08-08: whether the deferred per-class
`StatusResponseMap` helper could collapse real duplication and buy the four
trees genuine margin. It could not, on two independent grounds — it leaves a
majority-to-total fraction of every tree's client-to-client clones cross-file
and therefore unreachable (2 of petstore's 4, 123 of digitalocean's 236, 216
of github's 508), and reaching even the same-file fraction it can touch would
repeat the exact structural-identity merge `name-inline-schemas-by-operation-
and-status` already ruled out for inline models: two operations sharing a
response shape are not thereby returning the same thing, and merging them
because their fields line up invents a domain relationship the document never
stated. Kilbil has zero client-to-client clones for the helper to reach at
all; its two remaining clones and github's dominant model-to-model category
(74.8% of its clone-lines) are cross-file by construction — a shared shape is
never duplicated within its own file — so no scope of that helper reaches
them either.

This task cannot re-open that ruling — `retighten-the-generated-duplication-
ceilings.task-260804.typ`'s Non-goals already forbade "weakening what the
generated tier measures" and this task's own Non-goals forbid raising a
threshold or hiding a clone with an `ignorePattern`. What is left to check is
whether anything changed between 2026-08-08 and today that would put a
previously-unreachable clone back in reach, or move a tree's floor — `AGENT.md`'s
own standing rule ("check the artifact, not the summary") applies here exactly
as it did the first time.

== Choice

=== Fresh measurement, 2026-08-09, this task's base commit `368c92be`

Re-run with `jscpd -c .jscpd.generated.json --threshold 0 --reporters json`
against each tree individually, reading the JSON reporter's full-precision
`statistics.total.percentage` rather than the console table's two decimal
places, the same method `duplication-ceilings-follow-regeneration-not-
collapse` used:

#table(
  columns: (auto, auto, auto, auto, auto),
  [*Tree*], [*Ceiling*], [*Measured 2026-08-08*], [*Measured 2026-08-09*], [*Unchanged?*],
  [`examples/petstore/generated`], [4.41%], [4.4025157232704% (4 clones, 35/795)], [4.4025157232704% (4 clones, 35/795)], [Yes — byte-identical],
  [`tests/fixtures/generated/petstore`], [4.41%], [same as above], [4.4025157232704% (4 clones, 35/795)], [Yes — byte-identical],
  [`examples/kilbil/generated`], [1.42%], [1.4203454894434% (2 clones, 37/2605)], [1.4181678804140% (2 clones, 37/2609)], [Same 2 clones, same 37 lines; tree grew 4 lines from an unrelated format binding, percentage fell on its own],
  [`examples/digitalocean/generated`], [10.92%], [10.919996191806% (288 clones, 3441/31511)], [10.918263739053% (288 clones, 3441/31516)], [Same 288 clones, same 3441 lines; tree grew 5 lines from the same unrelated regeneration, percentage fell on its own],
  [`examples/github/generated`], [22.31%], [22.309539200296% (1431 clones, 24159/108290)], [22.309539200296% (1431 clones, 24159/108290)], [Yes — byte-identical],
)

Every clone count and duplicated-line count is unchanged from the 08-08
measurement. The two trees that moved (kilbil, digitalocean) moved by the
same "tree grows around unchanged clones" mechanism `duplication-ceilings-
follow-regeneration-not-collapse` already documented for the 08-04 -> 08-08
move, here traced to `4e565a71` ("chore(examples): regenerate digitalocean
for the format: byte built-in") and its sibling kilbil regeneration in the
same run — additive lines from an unrelated feature, not a change to what
either tree duplicates. Kilbil's two model-pair clones
(`Model/GoodsRequestContentItem`/`Model/GoodsXmlRequestContentItem`,
10 lines; `Model/ProcessSaleRequestContentGoodsDataItem`/
`Model/SearchClientRequestContentGoodsDataItem`, 29 lines) and petstore's
four clones (`Generated/PetClient.php` self-clone 14 lines,
`Generated/StoreClient.php`/`Generated/UserClient.php` cross-file 6+7 lines,
`Generated/UserClient.php` self-clone 12 lines) were read directly out of
today's JSON report and match `duplication-ceilings-follow-regeneration-not-
collapse`'s description exactly — verified against the artifact, not assumed
still true.

Rounding every measured figure UP to the next hundredth (the baselines
file's own convention) reproduces the existing ceiling in all five rows.
`scripts/jscpd-generated-baselines` therefore needs no numeric change — the
four rows it already carries are the measured floor today, not an inherited
number nobody re-checked.

=== Why the margin stays at (or effectively at) zero

Three of the four rows show literally 0.00 points of margin after rounding:
measured and ceiling round to the same two decimal places. Digitalocean
carries 0.0017 points (about half a duplicated line, at this tree's size) —
strictly positive, but under jscpd's smallest possible clone at
`minTokens: 50`, so a single new clone anywhere in the tree still turns it
red. None of the four is distinguishable from zero margin in practice.

This is not an oversight this task is failing to fix. `duplication-ceilings-
follow-regeneration-not-collapse` already established, and today's
re-measurement reconfirms unchanged, that every clone remaining in these four
trees falls into one of two categories with no lever this project can pull
without violating a standing ruling:

- *Cross-file, by construction.* Every model-to-model clone (kilbil's two,
  74.8% of github's clone-lines, 16.5% of digitalocean's) and a majority of
  every tree's client-to-client clones (2 of 4 petstore, 123 of 236
  digitalocean, 216 of 508 github) span two different files. A per-class
  helper cannot reach across files, and nothing else proposed reaches them
  either — see `duplication-ceilings-follow-regeneration-not-collapse`'s
  "Re-weighing the deferred collapse" section for the full accounting.
- *Structurally identical, semantically distinct.* Merging the reachable
  remainder — same-file `StatusResponseMap` literals, or the inline model
  pairs kilbil's two clones are — on the strength of their shape matching is
  the exact move `name-inline-schemas-by-operation-and-status` ruled out:
  "two endpoints that both return `{id, name}` may be returning a tag and a
  user, and collapsing them because their fields line up invents a domain
  relationship the document never stated." Every clone left in these four
  trees is either the vendor's document restating one shape under several
  names (model-to-model), or two operations whose declared responses happen
  to coincide (client-to-client) — never two call sites the generator wrote
  identically for no reason.

The two routes this task's own Non-goals rule out — raising a threshold, or
adding an `ignorePattern` over a genuine clone — are the only remaining ways
to manufacture headroom without reducing real duplication. Since real
reduction has been checked twice now (08-08 and today) and found blocked by
the ruling above, a deliberate zero is the honest answer, not a symptom of
this task being incomplete.

== Consequences

- `scripts/jscpd-generated-baselines`'s four rows are unchanged in value;
  each carries a short "re-measured 2026-08-09, unchanged" note pointing
  here rather than a stale silence that reads as nobody having checked.
- `Justfile`'s `lint-jscpd-generated` recipe comment gains a pointer to this
  decision alongside its existing pointer to `duplication-ceilings-follow-
  regeneration-not-collapse`.
- The cross-class, opt-in `StatusResponseMap` collapse that `duplication-
  ceilings-follow-regeneration-not-collapse` named and left unfiled remains
  the only lever that could someday buy real margin here — an explicit,
  consumer-facing opt-in naming which call sites are meant to be the same,
  not a shape-matching heuristic. This decision does not file that task; it
  confirms, a second time, that nothing short of it will move these four
  ceilings down for real.
- `just lint-jscpd-generated` stays green on all five measured trees with no
  `ignorePattern` added, no tree excluded, and no threshold raised — the
  recipes now also print each tree's measured percentage against its ceiling
  (`heal-the-duplication-gate-margins`), so the zero margin recorded here is
  visible on every run rather than only in this file.
