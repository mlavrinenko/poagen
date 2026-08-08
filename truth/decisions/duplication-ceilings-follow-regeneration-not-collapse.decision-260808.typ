#import "@local/speconaut:0.1.0": *
#import "../domain/generation.context.typ": *

#show: decision.with(
  title: "The generated tier's loosened ceilings come back down by re-measurement, not by the deferred collapse",
  status: accepted(2026, 8, 8),
  contexts: (generation-context,),
  goals: (link("../goals/strict-clean-output.goal.typ"),),
  standards: (link("../standards/analysis-runs-at-maximum-strictness.standard-260729.typ"),),
  relates-to: (
    link("generated-duplication-ceiling-is-per-tree.decision-260803.typ"),
    link("envelope-remeasures-the-generated-duplication-floors.decision-260804.typ"),
    link("name-inline-schemas-by-status-and-merge-on-request.decision-260804.typ"),
  ),
  process-only: "governs poagen's own duplication-gate configuration for the generated tier — what `just lint-jscpd-generated` measures and `scripts/jscpd-generated-baselines` records — not what the generator produces or what a reimplementation must do",
)

== Context

`envelope-remeasures-the-generated-duplication-floors` loosened all four
`examples/*/generated` ceilings (and the fixture fallback) on 2026-08-04,
explicitly as deliberate, temporary slack: "the floors come back down under
`retighten-the-generated-duplication-ceilings`." That task is this decision.

Between 2026-08-04 and today, none of the four trees were touched for
duplication reasons, but three were regenerated for other, unrelated
reasons: `812efad1` regenerated kilbil against its reconciled schema,
`a8d3027e` renamed the vendor to poagen across every emitted namespace and
string, and `2a314707` regenerated github and digitalocean after refining
what the emitter's own PHPDoc emission produces. Re-measuring on today's
tree, rather than trusting the 08-04 numbers, is the point of this task —
`AGENT.md`'s own standing rule ("check the artifact, not the summary") is
exactly the failure mode a stale ceiling would repeat.

== Choice

=== Measurement method

`just lint-jscpd-generated`, run twice, byte-identical both times (verified
against the trap this task's own brief names: jscpd percentages can move
between runs if the generated trees are regenerated in between — they were
not, here). For the rounding the baselines file's own convention needs
(measured figure rounded UP to the next hundredth), the console reporter's
two decimal places are not enough to tell "already at the ceiling" apart
from "a hair under it", so each tree was also measured with jscpd's `json`
reporter (`jscpd -c .jscpd.generated.json --threshold 0 --reporters json`),
which carries the percentage to full floating-point precision.

=== Every ceiling, before and after

#table(
  columns: (auto, auto, auto, auto),
  [*Tree*], [*Loosened 2026-08-04*], [*Measured 2026-08-08*], [*New ceiling*],
  [`examples/petstore/generated`], [4.41%], [4.4025157232704% (4 clones, 35/795, unchanged)], [4.41% — unchanged],
  [`examples/kilbil/generated`], [1.47%], [1.4203454894434% (2 clones, 37/2605)], [1.43%],
  [`examples/digitalocean/generated`], [10.97%], [10.919996191806% (288 clones, 3441/31511)], [10.92%],
  [`examples/github/generated`], [22.32%], [22.309539200296% (1431 clones, 24159/108290)], [22.31%],
  [`tests/fixtures/generated/*` (uniform, worst tree)], [4.41%], [same as `examples/petstore/generated`], [4.41% — unchanged],
)

Three of the four move down. None of the three moved because duplicated
content was collapsed — every one moved because the tree the ceiling
measures got bigger around clones that did not:

- *kilbil* (1.47% -> 1.43%): still exactly the same 2 clones, still exactly
  37 duplicated lines — `Model/GoodsRequestContentItem` against
  `Model/GoodsXmlRequestContentItem` (10 lines) and
  `Model/ProcessSaleRequestContentGoodsDataItem` against
  `Model/SearchClientRequestContentGoodsDataItem` (29 lines), the same pair
  `generated-duplication-ceiling-is-per-tree` first named. The tree grew
  2530 -> 2605 lines when `812efad1` regenerated it against the reconciled
  schema, and the percentage fell on its own — the exact "no decision
  needed to lower a floor" case that decision's own RATCHET paragraph
  already covers.
- *digitalocean* (10.97% -> 10.92%): not a pure denominator effect — clones
  went 287 -> 288 and duplicated lines 3424 -> 3441, a real (small) increase.
  But the tree grew 31315 -> 31511 lines (`2a314707`, refining PHPDoc
  emission and picking up a few additive model properties along the way),
  outpacing the 17-line increase in duplication, so the percentage still
  fell. This is not "a clone the emitter could have avoided" being rewarded
  — it is the same tree-grows-around-unchanged-content shape as kilbil, with
  one small additional real clone riding along, and the new ceiling is the
  measured figure either way, not a number picked to be generous.
- *github* (22.32% -> 22.31%): clone count and duplicated-line count are
  byte-identical to the 08-04 measurement — 1431 clones, 24159 duplicated
  lines, both exactly unchanged. Only the tree's total line count moved,
  108267 -> 108290 (+23), from the same `2a314707` PHPDoc-emission refinement
  that touched digitalocean, applied here as purely additive documentation
  lines the `.jscpd.generated.json` `ignorePattern` already excludes from
  matching. The ceiling falls by one hundredth purely because the
  denominator grew under unchanged duplication.
- *petstore and its fixture twin* (4.41%, unchanged): byte-for-byte
  identical to the 08-04 measurement — 4 clones, 35 duplicated lines, 795
  total lines. Nothing regenerated this tree in the interim. The ceiling was
  already the measured figure rounded up (4.4025% -> 4.41%) and cannot fall
  further without collapsing real duplication, which is the next section.

=== Re-weighing the deferred collapse: a per-class `StatusResponseMap` helper

`envelope-remeasures-the-generated-duplication-floors` named and deferred
one lever: hoisting a class's repeated `StatusResponseMap` construction
literals into a private per-class helper. It rejected reaching for it in
that round on two grounds — it does not fully work (petstore's cross-file
clones), and what it does reach is structural dedup of the same kind the
owner already ruled out for inline models. Re-checked against today's tree,
both grounds hold, and the first is worse than it looked in petstore alone.

*It still does not fully work, and not only on petstore.* Categorizing every
current client-to-client clone by whether the two files it spans are the
same class or different classes (a per-class helper can only reach the
same-class case):

#table(
  columns: (auto, auto, auto, auto),
  [*Tree*], [*Client-to-client clones*], [*Same-file (reachable)*], [*Cross-file (unreachable)*],
  [`examples/petstore/generated`], [4 of 4 total clones], [2 (`PetClient.php`, 12+14=26 lines)], [2 (`StoreClient.php` / `UserClient.php`, 6+7=13 lines)],
  [`examples/digitalocean/generated`], [236 of 288 total clones (2902 lines, 77.8%)], [113 (1614 lines)], [123 (1288 lines — e.g. `AccountClient::accountGet` against `ActionsClient::actionsGet` sharing an error tail)],
  [`examples/github/generated`], [508 of 1431 total clones (5441 lines, 21.3%)], [292 (3193 lines)], [216 (2248 lines)],
  [`examples/kilbil/generated`], [0], [—], [—],
)

Petstore's split (2 of 4 clones cross-file) is unchanged from 08-04's own
finding — still true, with fresh numbers matching exactly. Extended to the
two larger trees for the first time here, the same shape recurs at scale:
on digitalocean, more than half the client-to-client duplication (123 of
236 clones) is cross-file; on github, nearly half (216 of 508) is. A helper
scoped to one class would leave all three trees red regardless of how
aggressively it hoists what it *can* reach — it was never going to zero any
of them out, and the fraction it cannot reach is not a rounding error.

Model-to-model duplication — 74.8% of github's clone-lines and 16.5% of
digitalocean's — is cross-file by construction: two files share a shape
only when they are, definitionally, two different files. Verified directly
(0 of github's 897 model clones are same-file). A per-class helper has
nothing to offer this category at all, at any scope.

*It is still the same structural move the owner already rejected, one layer
up.* See the ruling quoted below — merging two operations' `StatusResponseMap`
literals because they happen to match is the identical move to merging two
inline schemas because their fields line up: both infer that two things the
document declared separately are the same thing, from shape alone.

*Conclusion:* the collapse route is not "worth doing" as a per-class helper
— it was already known to leave petstore red, and today's numbers show it
would leave digitalocean and github more clearly red too, reaching under
half of even their client-to-client category and none of their dominant
model-to-model category. If a collapse is worth pursuing at all, it needs
two things a per-class helper does not have: reach *across* classes (to
close the StoreClient/UserClient, AccountClient/ActionsClient shape of
clone), and a trigger that is not "the literals happen to match" — per the
ruling below, an explicit opt-in naming which call sites the consumer
*means* to be the same, the same shape `Profile::$inlineModels` already
uses for inline schemas. That is a new lever, not the one this round
re-evaluated, and it touches `src/Generator/Emit/` and probably `Profile.php`
— outside this task's boundary. A follow-up task can be written directly
from this paragraph.

=== Checked against the 2026-08-02 ruling on inline models

Any structural dedup proposed here has to clear the same bar the owner set
in `name-inline-schemas-by-operation-and-status.task-260802.typ`, which
settled kilbil's 36 identical inline `403` bodies as "36, unless a human
says otherwise":

#quote(block: true)[
  Structural identity is not identity of meaning. Two endpoints that both
  return `{id, name}` may be returning a tag and a user, and collapsing them
  because their fields line up invents a domain relationship the document
  never stated.
]

`envelope-remeasures-the-generated-duplication-floors` already applied this
ruling to the per-class helper once ("the same move one layer up the
stack"); nothing measured here changes that read. It also forecloses a
different collapse this task's numbers might otherwise tempt: github's
1837 `Webhook*` models and its 389-clone `DiscussionAnswerChosenBy` object,
and digitalocean's shared `Error`/`BasicError` tail, are model-to-model
duplication the document itself creates by re-declaring one shape under
many component names. Merging those on structural identity is the exact
case the ruling above exists to block — each stays as many classes as the
document names, and that portion of every tree's floor (all of kilbil's,
74.8% of github's clone-lines, 16.5% of digitalocean's) is not a lever this
project can use at all, not merely one deferred again.

== Consequences

- `scripts/jscpd-generated-baselines`'s four `examples/*/generated` rows
  move to this decision's table (petstore unchanged, kilbil 1.47 -> 1.43,
  digitalocean 10.97 -> 10.92, github 22.32 -> 22.31), each with its
  commentary rewritten to describe what re-measurement found rather than
  what the 08-04 loosening recorded. Its RATCHET section gains a paragraph
  pointing here.
- `Justfile`'s `lint-jscpd-generated` recipe comment gains a note that the
  4.41 fixture fallback was re-verified against today's tree and is
  unchanged — still the measured floor, not inherited without re-checking.
- `retighten-the-generated-duplication-ceilings` can close: every ceiling
  it owns bringing down either moved down by real re-measurement or is
  recorded here as already at its floor. It does not close the gap a
  cross-class, opt-in `StatusResponseMap` collapse could still close — that
  stays a distinct, not-yet-filed task, scoped by the "Re-weighing the
  deferred collapse" section above, and out of this task's boundary
  (`src/Generator/Emit/` is untouched by this decision).
- `just lint-jscpd-generated` is green on all five measured trees at the
  new ceilings, with no `ignorePattern` added, no tree excluded, and no
  change to what the envelope represents.
