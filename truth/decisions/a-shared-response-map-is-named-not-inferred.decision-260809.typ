#import "@local/speconaut:0.1.0": *
#import "../domain/generation.context.typ": *
#import "../domain/guidance.context.typ": *

#show: decision.with(
  title: "A repeated response map collapses only where a consumer names it, and poagen's own example documents are not poagen's to name",
  status: accepted(2026, 8, 9),
  contexts: (generation-context, guidance-context),
  goals: (
    link("../goals/user-code-guides-generation.goal.typ"),
    link("../goals/guidance-cannot-mislead.goal.typ"),
    link("../goals/strict-clean-output.goal.typ"),
  ),
  standards: (
    link("../standards/guidance-is-data-not-code.standard-260729.typ"),
    link("../standards/regeneration-is-deterministic-and-total.standard-260729.typ"),
  ),
  relates-to: (
    link("name-inline-schemas-by-status-and-merge-on-request.decision-260804.typ"),
    link("duplication-ceilings-follow-regeneration-not-collapse.decision-260808.typ"),
    link("generated-tier-ceilings-cannot-fall-further.decision-260809.typ"),
  ),
)

== Context

Two decisions examined why the generated tier's four ceilings cannot fall and
reached the same answer eight days apart — `duplication-ceilings-follow-
regeneration-not-collapse` (2026-08-08) and `generated-tier-ceilings-cannot-
fall-further` (2026-08-09). Both named exactly one lever with real margin
behind it: an opt-in collapse of the `StatusResponseMap` declarations that
repeat across operations and across sub-client classes. Neither filed it,
each on the reasonable ground that it sat outside its own boundary.

The constraint on that lever was settled before either decision was written.
`name-inline-schemas-by-status-and-merge-on-request` records the owner ruling
of 2026-08-02:

#quote(block: true)[
  Structural identity is not identity of meaning. Two endpoints that both
  return `{id, name}` may be returning a tag and a user, and collapsing them
  because their fields line up invents a domain relationship the document
  never stated.
]

So the lever cannot be a deduplication pass over emitted output. It has to be
a profile surface on which a consumer states which call sites they mean to be
the same — the shape `Profile::$inlineModels` already uses one layer down.

== Choice

=== The mechanism

`Profile::$responseMaps` maps a PHP method name to the operations whose
response map is one shared declaration. The emitter writes that declaration
once, onto a new `Generated\ResponseMaps` class sitting beside `ApiClient`,
and every named operation calls it in place of its own literal.

A class of its own, not a private helper per client, and that is the whole
point of the shape: the duplication both prior decisions measured is
majority cross-file — 123 of digitalocean's 236 client-to-client clones, 216
of github's 508 — so a per-class helper was never going to reach it. A holder
in the client namespace reaches every sub-client at once.

Three properties hold by construction rather than by care:

- *Nothing is inferred.* A document where two unrelated operations happen to
  declare identical responses emits them separately. Only an entry naming
  them collapses them, and an entry is a claim about meaning that only the
  consumer can make.
- *Declaring nothing costs nothing.* No entry means no holder file and no
  changed byte anywhere. Verified by regenerating all four `examples/*`
  trees and diffing: no drift on any of them.
- *A wrong entry fails before anything is written.* What is answerable from
  the profile alone — a key that is not a PHP method name, two keys differing
  only in case, a group of fewer than two operations, an operation named
  twice or claimed by two groups — is refused before the document is read at
  all. What needs the document — an operation the document does not carry,
  an operation this run does not emit, a group whose maps are not in fact
  identical — joins the run's single collected report, naming the entry, the
  two members that disagree, and the first status they disagree about.

Identity is identity of the emitted declaration, not of the spec objects
behind it: two operations share a map exactly when the emitter would write
the same literal for both. That reading cannot rot as the response-spec type
grows a field, which a hand-enumerated comparison would.

=== Measured effect on the five measured trees: none

Measured with `just lint-jscpd-generated` at this task's base commit
`e80b7501` and again on the finished tree:

#table(
  columns: (auto, auto, auto, auto),
  [*Tree*], [*Ceiling*], [*Before*], [*After*],
  [`tests/fixtures/generated/petstore`], [4.41%], [4.40% (4 clones, 35/795)], [4.40% (4 clones, 35/795)],
  [`examples/petstore/generated`], [4.41%], [4.40% (4 clones, 35/795)], [4.40% (4 clones, 35/795)],
  [`examples/kilbil/generated`], [1.42%], [1.42% (2 clones, 37/2609)], [1.42% (2 clones, 37/2609)],
  [`examples/digitalocean/generated`], [10.92%], [10.92% (288 clones, 3441/31516)], [10.92% (288 clones, 3441/31516)],
  [`examples/github/generated`], [22.31%], [22.31% (1431 clones, 24159/108290)], [22.31% (1431 clones, 24159/108290)],
)

Every clone count, duplicated-line count and total is identical before and
after, because no profile in this repository declares a group. No ceiling
moves, and `scripts/jscpd-generated-baselines` needs no numeric change for
the third time running. That is the recorded outcome, not a shortfall.

The source tier moved 2.63% to 2.65% against its 3.0% threshold (145 clones
over 436 files) — four new source files and three new test files, whose only
clones are the three-file class-docblock family ten other test pairs in this
tree already form. It is not raised.

=== What the lever is worth, measured rather than projected

The reach was bounded from the committed trees themselves: an operation is
reachable when its emitted map literal is byte-identical to at least one
other operation's.

#table(
  columns: (auto, auto, auto, auto),
  [*Tree*], [*Operations*], [*Distinct maps*], [*Reachable operations*],
  [`examples/petstore/generated`], [19], [15], [7 in 3 groups (36.8%)],
  [`examples/kilbil/generated`], [36], [36], [0 (0.0%)],
  [`examples/digitalocean/generated`], [596], [427], [191 in 22 groups (32.0%)],
  [`examples/github/generated`], [1098], [748], [493 in 143 groups (44.9%)],
)

Kilbil's zero is the same finding both prior decisions recorded: every
operation's response class is named by operation and status, so no two
literals coincide even though all 36 declare the same status pair.

Each tree was then regenerated twice into scratch directories — once with an
empty `$responseMaps`, once with every reachable group named — and both runs
measured. The empty runs reproduce the committed goldens' figures exactly,
which is what makes the paired runs comparable:

#table(
  columns: (auto, auto, auto),
  [*Tree*], [*No group named*], [*Every reachable group named*],
  [`examples/petstore/generated`], [4.402516% (4 clones, 35/795)], [0.000000% (0 clones, 0/853)],
  [`examples/kilbil/generated`], [1.418168% (2 clones, 37/2609)], [1.418168% (2 clones, 37/2609)],
  [`examples/digitalocean/generated`], [10.918264% (288 clones, 3441/31516)], [7.484342% (201 clones, 2378/31773)],
  [`examples/github/generated`], [22.309539% (1431 clones, 24159/108290)], [19.659980% (1190 clones, 21590/109817)],
)

So the lever is real: it removes every clone petstore has, a third of
digitalocean's duplicated lines and a ninth of github's. Total lines rise
slightly in each case — the holder class is new code — and the percentage
still falls by 2.65 to 4.40 points.

=== Why none of that lands in a committed tree

The groups above were derived by grouping operations whose emitted literals
match. That derivation is precisely the move the 2026-08-02 ruling forbids.
Running it offline and pasting its answer into `examples/*/poagen.php` would
not make it a consumer's claim; it would launder a shape-matching heuristic
through a profile file and leave 22 and 143 unreviewed assertions of sameness
in trees whose documents poagen does not own. The example trees exist to show
what poagen emits from a real vendor document, and a maintainer of the
generator has no standing to declare that 64 DigitalOcean operations mean the
same thing.

The measurement therefore stands as an upper bound on what an honest
consumer could gain, and nothing more. It is recorded here so the next
revisit inherits a number instead of re-deriving one, which is the failure
mode `retighten-the-generated-duplication-ceilings` exists because of.

A dedicated fixture — `tests/fixtures/generated/shared-response-maps`, from a
four-operation document across two tags — carries the feature instead, so the
emitted holder is held to the generated tier's no-baseline PHPStan absolute
and to the duplication gate like every other emitted tree. It measures 0.00%
against the 4.41% fixture fallback.

== Consequences

- `Profile::$responseMaps` is the fourth guidance field that merges rather
  than renames, and the third whose validation splits across "answerable from
  the profile" and "needs the document" — the same line
  `built-in-uuid-and-binary-format-bindings` drew for `$formats`.
- The generated tier gains one tree, `tests/fixtures/generated/shared-
  response-maps`, at 0.00% under the uniform 4.41% fixture fallback. No row
  is added to `scripts/jscpd-generated-baselines`, which covers
  `examples/*/generated` only.
- All four `examples/*/generated` trees and every existing fixture golden are
  byte-identical to what the base commit emitted. `just check-examples`
  reports no drift on any example.
- The four ceilings stay where `generated-tier-ceilings-cannot-fall-further`
  left them, now for a different reason than that decision recorded: not
  "there is no lever", but "the lever exists, is measured, and is the
  consumer's to pull". A future task that moves one of them will be a
  consumer opting in, not an emitter change.
- The `StatusResponseMap` collapse is no longer an unfiled idea named twice
  and built never. Anything still wanting margin on these trees has to
  contend with the measurement above rather than re-derive it.
