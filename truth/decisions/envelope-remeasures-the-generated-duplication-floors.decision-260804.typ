#import "@local/speconaut:0.1.0": *
#import "../domain/generation.context.typ": *

#show: decision.with(
  title: "The envelope changes what the generated tier represents, so its duplication floors are re-measured",
  status: accepted(2026, 8, 4),
  contexts: (generation-context,),
  goals: (link("../goals/strict-clean-output.goal.typ"),),
  standards: (link("../standards/analysis-runs-at-maximum-strictness.standard-260729.typ"),),
  relates-to: (link("generated-duplication-ceiling-is-per-tree.decision-260803.typ"),),
  process-only: "governs paogen's own duplication-gate configuration for the generated tier — what `just lint-jscpd-generated` measures and `scripts/jscpd-generated-baselines` records — not what the generator produces or what a reimplementation must do",
)

== Context

`typed-error-responses` switched every generated operation from emitting one
picked `ResponseType` to emitting the document's full responses object — a
`StatusResponseMap` covering every status the document declares, not only the
one that used to drive the method's return type.
#link("envelope-supersedes-error-response-policy.decision-260804.typ")[Every operation returns a status-and-body envelope, typed per declared response] records why; this decision is about what that change did to #link("generated-duplication-ceiling-is-per-tree.decision-260803.typ")[The generated tier's duplication ceiling is measured per tree, not once across the corpus]'s floors, not about the envelope itself.

`a5ed2ad7` (merging the switch) shipped with `lint-jscpd-generated` red on
four trees: `tests/fixtures/generated/petstore` and
`examples/petstore/generated` at 8.2% against ceilings of 2.0% and 0.00%,
`examples/digitalocean/generated` at 11.0% against 6.27%, and
`examples/github/generated` at 24.1% against 20.65%. Every operation now
inlines a full per-status `StatusResponseMap` literal where it used to inline
one `ResponseType`, and operations that share a response shape — real in the
Petstore, DigitalOcean and GitHub documents — clone more of that literal than
before.

=== Why this is not the regression the tier exists to catch

`generated-duplication-ceiling-is-per-tree`'s own record
(`scripts/jscpd-generated-baselines`, in the paragraph documenting why the
per-tree gate still works) names the regression this tier was calibrated
against and how it was verified: planting "the emitter abandons `runtime/`
and inlines request assembly per operation" on scratch copies of two trees on
2026-08-03 took DigitalOcean from 6.27% to 8.30% and the petstore fixture from
0.00% to 8.60%, both red, both naming the file and the line range. The
`Justfile`'s `lint-jscpd-generated` recipe comment states the same intent in
one line: the tier exists to catch "the same 12-to-15 token-identical lines
repeating across every operation in an emitted client" — an emitter that stops
delegating to `runtime/` and writes request assembly out by hand instead.

The envelope does not do that. Every operation still ends in exactly one
`$this->transport->send(Endpoint::..., ResponseType::envelope(new
StatusResponseMap(...)))` call — `runtime/`'s transport contract is unchanged,
and `HttpTransport` is unaffected. What changed is the size and shape of the
second argument: it now names every declared status and every declared body,
where before it named one. Two operations that already shared a request shape
now also compare on a longer, richer description of their responses, so a
document with real shape reuse — a shared `Error` model on DigitalOcean's
error tail, a shared `Order` response on two Petstore operations — clones more
of that description than it used to. That is the tier measuring the document
more completely, in exactly the way it was designed to: per
`generated-duplication-ceiling-is-per-tree`, "neither figure is duplicated
LOGIC — both are the vendor's document restated in PHP."

=== The collapse applied before any ceiling moved

`dc6a9035` collapsed what could be collapsed without touching a ratchet,
before this decision or any number in `scripts/jscpd-generated-baselines`
changed: `StatusResponseMap`'s `ranges`/`default` arguments are omitted when
they equal the constructor's own defaults, and a declared-but-bodyless status
is written `null` instead of spelling out `ResponseType::nothing()`. Measured,
before that commit to after:

#table(
  columns: (auto, auto, auto),
  [*Tree*], [*Before*], [*After*],
  [petstore (`examples/*/generated` and its fixture twin)], [8.2%], [4.4%],
  [digitalocean], [11.0%], [10.9%],
  [github], [24.1%], [22.3%],
)

A third lever — dropping the `/** @var */ $result = ...; return $result;`
intermediate variable — was evaluated in the same commit and rejected:
`ResponseType::envelope()` is hard-typed `self<Envelope<mixed>>` regardless of
what a `StatusResponseMap` literal actually contains, so PHPStan correctly
refuses `return $this->transport->send(...)` directly against the method's
own `@return Envelope<Union>` without an unsafe cast. All four trees stayed
red after the collapse: what remained is duplicated content the vendor's
document genuinely repeats, reachable only by hoisting a class's repeated
`StatusResponseMap` literals into a shared helper — a fourth lever outside the
two authorised for that round.

== Choice

The owner's ruling: loosen the four ceilings now, to their measured figures
after the collapse above, rather than spend the fourth lever under release
pressure. Functionality and stability first; the floors come back down under
`retighten-the-generated-duplication-ceilings`.

Measured on the current tree, the same way `generated-duplication-ceiling-is-
per-tree` measures it (`jscpd -c .jscpd.generated.json --threshold 0
<tree>`), before this decision's ceilings to after:

#table(
  columns: (auto, auto, auto),
  [*Tree*], [*Before*], [*After (new ceiling)*],
  [`examples/petstore/generated`], [0.00%], [4.41%],
  [`examples/kilbil/generated`], [1.68%], [1.47%],
  [`examples/digitalocean/generated`], [6.27%], [10.94%],
  [`examples/github/generated`], [20.65%], [22.32%],
  [`tests/fixtures/generated/*` (uniform, worst tree)], [2.0%], [4.41%],
)

kilbil's ceiling moves down, not up: its two clones are unchanged — the same
two same-shape model pairs `generated-duplication-ceiling-is-per-tree` already
named — and the tree grew around them, so the percentage fell on its own. No
decision is needed to lower a floor; the RATCHET paragraph already permits
that in either file. The fixture uniform threshold moves to match
`examples/petstore/generated`'s new ceiling because
`tests/fixtures/generated/petstore` is the same document, emitted twice, and
is the worst fixture tree either way.

Every number and the reasoning behind it lives in
`scripts/jscpd-generated-baselines`, per tree, so it can be cited rather than
copied; a figure restated here would go stale the next time a tree is
measured again.

=== What was considered and rejected: hoisting shared response maps

Hoisting a class's repeated `StatusResponseMap` literals into a per-class
private helper — the fourth lever `dc6a9035` named and deferred — was
considered again here and rejected for this round, on two grounds.

First, it does not fully work. Two of petstore's four remaining clones are
cross-file: `StoreClient.php` against `UserClient.php`, two operations on
*different* clients declaring the same status-to-shape pair. A per-class
helper cannot reach across classes, so petstore stays over 0.00% regardless of
how aggressively a single class's own repeats are hoisted — the ceiling this
decision sets for petstore is not fully undone by the helper even if it ships.

Second, it is structural deduplication of the same kind the owner already
ruled out for inline models, and for the same reason. Kilbil's response
classes are the direct precedent: `name-inline-schemas-by-operation-and-
status.task-260802.typ` names 36 identical inline `403` bodies across kilbil's
36 operations and settles the question of merging them as "36, unless a human
says otherwise" — "structural identity is not identity of meaning. Two
endpoints that both return `{id, name}` may be returning a tag and a user, and
collapsing them because their fields line up invents a domain relationship the
document never stated." A helper that hoists two operations' identical
`StatusResponseMap` literals because the literals happen to match makes the
same move one layer up the stack: it merges call sites because their *output*
matches, not because the document says the two operations mean the same
thing. The reasoning that keeps kilbil's 36 classes separate keeps a
cross-operation response-map helper out of this round too — it is a real
lever, evaluated and available, but it is structural dedup and stays deferred
rather than reached for to make a number green.

== Consequences

- `scripts/jscpd-generated-baselines`' four `examples/*/generated` rows and
  the `lint-jscpd-generated` recipe's fixture fallback in `Justfile` (2.0 to
  4.41) move to the figures in the table above, each with its own
  before-collapse, after-collapse commentary rewritten to describe what the
  tree contains now rather than what it contained before the envelope.
- Both files' RATCHET language gains the carve-out this decision is the first
  user of: a floor may move up when a reviewed change alters what the emitter
  represents, recorded in a decision artifact with every tree's before and
  after number — never as a bare edit to a ratchet with no artifact behind
  it, and never for a clone the emitter could have avoided, which stays
  exactly as forbidden as it always was.
- `retighten-the-generated-duplication-ceilings` owns bringing every row this
  touched back down, starting from the fourth lever named and deferred above
  — a per-class `StatusResponseMap` helper — and covering only what such a
  helper can actually reach; petstore's cross-file clones and any
  document-level shape reuse (DigitalOcean's shared `Error` model, GitHub's
  shared `BasicError`) need a design that is not scoped to one class, or stay
  as the document-shaped floor `generated-duplication-ceiling-is-per-tree`
  already says a correct emitter cannot get under.
- `just lint-jscpd-generated` is green again on all five measured trees
  (`tests/fixtures/generated/*` under the shared 4.41% ceiling, four
  `examples/*/generated` trees each at its own row) with no ratchet edited
  outside what this decision records.
