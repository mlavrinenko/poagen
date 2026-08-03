# Session plan, written 2026-08-03

Supersedes nothing. `session-resume-260803b.md` still holds for everything it
says about the union, the tripwire lesson and the standing hazards; this note
adds the backlog surgery done on top of it and the plan for the next session.
`backlog-handoff-260802.md` and `session-resume-260803.md` remain history.

## Tree state

`main`, working tree clean, `scripts/gated-check` green (exit 0) before the
backlog edits below. 78 skip entries: 38 DigitalOcean, 40 GitHub.

This session wrote no code. It measured, and it reshaped the backlog so the
next one can be handed to Sonnet agents.

## What was measured, and where the backlog was wrong

Every figure below came from a probe against the two vendor documents, run on
this tree. None of it was taken from a task's own text — two of the three
things that turned out to be wrong were wrong in a task an owner had accepted.

### Every remaining skip entry, by cause

All 78 fall into exactly two open tasks' scope, and nothing else is left:

| cause | ops | task |
|---|---|---|
| `allOf` request body | 18 DO | `merge-allof-members-into-one-model` |
| `allOf` response (`apps/create-from-manifest` 201) | 1 GH | same |
| `oneOf`/`anyOf` request body | 13 DO + 14 GH | `a-union-request-body-takes-a-union-parameter` |
| `oneOf`/`anyOf` response | 8 GH | `a-union-response-selects-its-branch` |
| media type with no `schema` key | 1 GH | `a-media-type-with-no-schema-takes-a-raw-body` |
| parameter shape | 7 DO + 16 GH | `support-the-parameter-shapes-real-documents-use` |

55 + 23 = 78. Those five tasks take the skip list to zero.

### Three things the backlog said that are not true

- **The composition task's count.** It claimed 68 operations (43 DO + 16 GH
  bodies, 9 GH responses). Measured: 55. It was written when the skip lists
  held 100 entries. Its fourth shape — "declares `properties` with no
  `type: object`" — was closed by `close-the-three-sites-that-widen-a-declared-shape`,
  and its named example `kubernetes_upgrade_cluster` generates today. One of
  its "9 GH responses" is an `allOf`, not a union.
- **The parameter task's causes.** Its count of 23 is right; two of its four
  causes are not. `job_names` is DigitalOcean's, not GitHub's, and its items
  *are* a plain scalar — behind a `$ref`, which is the same cause as the other
  eleven. And "the scalar-union work already resolves this shape elsewhere" is
  false for GitHub's `fields`/`has`: `resolveScalarUnion()` returns `null` the
  moment a branch is an array, and all nine are `string | list<string>`.
- **`typed-error-responses` contradicted `name-inline-schemas-by-operation-and-status`.**
  One required 36 identical kilbil 403 schemas to collapse onto one model; the
  other, ruled by the owner four weeks later, required 36 classes unless a
  human merges them. Both were `accepted`. An agent handed either would have
  built something the other forbids. Corrected in favour of the later ruling,
  with a `depends-on` edge added so the order is legible.

### A defect nobody had filed

Eleven operations across the two large documents ship an untyped
`array<string, mixed> $body` today for a schema that declares its shape.

Nine are DigitalOcean's, through an `allOf`: `vpcs_create`, `vpcs_update`,
`vpcs_patch_peerings`, `vpcPeerings_create`, `vpcPeerings_patch`,
`uptime_create_check`, `uptime_update_check`, `uptime_create_alert`,
`uptime_update_alert`. Two are GitHub's, through a `oneOf`:
`orgs/delete-attestations-bulk` and `users/delete-attestations-bulk`, whose
document says in prose "either `subject_digests` or `attestation_ids`, but not
both" and whose emitted signature says nothing at all.

One root cause, and `vpcs_update` against `vpcs_patch` is the proof: same two
`$ref` members, and the only difference is that `vpcs_update` writes
`type: object` on the node. `RequestBodyAnalyzer` reads the keyword, finds an
object with no declared properties, and emits `KIND_JSON_MAP`. So one refuses
loudly and the other widens silently, on identical schemas.

This is the fourth site of the widening root cause
`close-the-three-sites-that-widen-a-declared-shape` closed at three, it is
silent, and it is in committed example trees. Folded into the two tasks that
fix each keyword rather than filed separately, because it is the same change:
the nine into `merge-allof-members-into-one-model`, the two into
`a-union-request-body-takes-a-union-parameter`. Neither set is skip-listed, so
nothing in the gate would have caught them.

Not the same and deliberately not filed:
`copilot/set-copilot-content-exclusion-for-organization` emits
`array<string, list<mixed>>` where the map and the list are typed and only an
`anyOf` inside the items degrades. Recorded as a non-goal in the union task.

## Backlog changes

- `resolve-composition-schemas-in-bodies-and-responses` → `cancelled`, split
  into four tasks with measured scopes and disjoint mechanisms.
- `support-the-parameter-shapes-real-documents-use` → summary rewritten
  against the measurement; three mechanisms instead of four; a ruling written
  in for the scalar-or-list case.
- Two decisions that were owed with no task behind them are now tasks:
  `record-the-union-pin-as-a-second-opt-out`,
  `record-the-per-tree-duplication-ceilings`.
- `v01-release-exit-criteria` → the six roadmap criteria are enumerated with
  their current truth. Three already hold, two are stale, one is real work.
- `webhooks-refuse-with-no-opt-out` → carries a recommended ruling to argue
  against. Still `proposed`; it needs the owner.
- `turn-on-the-speconaut-session-workflow` → its blocker closed; the task said
  otherwise.

29 non-terminal tasks.

## Two rulings, proposed then reversed by the owner the same day

Both were drafted here as ignore-with-a-notice or normalise-it-away, and the
owner rejected both on one principle: paogen fails when it cannot generate
something, and the consumer decides whether to skip. Recorded because the
reasoning that lost is the reasoning a future session will re-derive.

- **An `anyOf` member of an `allOf` becomes a union of branch models.** The
  draft dropped the constraint with a notice, arguing that paogen ignores
  `minLength` and `pattern` too. It is not a choice between ignoring and
  refusing: `anyOf` is a union and a union is expressible. `firewalls_create`
  emits `FirewallsCreateInboundRules|FirewallsCreateOutboundRules`, both
  branches carrying the full merged shape and one extra required field, names
  taken from the `title` each branch declares. The constraint moves into the
  type and nothing is lost. Where a branch set cannot be a union, the operation
  refuses and the consumer skips it.
- **A scalar-or-list query parameter keeps both arms.** The draft normalised
  `string | list<string>` to a plain list, since a one-element list is the same
  bytes under `style: form`. The rule instead is: emit the widest native type
  the branches share and let the PHPStan annotation carry what native PHP
  loses. So `string|array|null` with `@param string|list<string>|null`. Nine
  GitHub operations.

Also recorded, so it is not re-derived: **`allOf` is not an intersection
type.** An `allOf` payload is one flat JSON object carrying the union of its
members' properties, not a value that is two things at once. `X&Y` would need
paogen to emit a property-declaring interface per component, since an
intersection of two classes is uninhabitable — the only model interfaces it
emits today are the empty union markers `UnionInterfaceEmitter` writes, which
constrain no shape. Non-goal, with the reasoning, in the allOf task.

## Release track, settled 2026-08-03 and moved to the end

The owner ruled the packages publish under a new vendor with the PHP
namespaces renamed to match:

| today | published as |
|---|---|
| `mlavrinenko/paogen` / `Mlavrinenko\Paogen\` | `poagen/client-generator` |
| `mlavrinenko/paogen-runtime` / `Mlavrinenko\Paogen\Runtime\` | `poagen/client-runtime` |
| `examples/kilbil` | `maximaster/kilbil-client` |

The generator ships too, reversing the earlier deferral. Rector does the
rename — `RenameClassRector`, never a textual replace, because docblocks and
`@param` annotations carry the same symbols. The whole track is now the LAST
session's work, not this one's, and `publish-the-runtime-package-to-packagist`
depends on `rename-the-vendor-packages-and-namespaces-before-publishing`.

**One string is unconfirmed and the rename task blocks on it.** The owner wrote
the vendor as `poagen`; this repository spells the project `paogen` everywhere.
They differ by a transposition, and a claimed Packagist name plus a namespace
in someone's lockfile is not recoverable. Get the one-word answer first.

## A rule that came out of this, worth keeping

A task that fixes or enhances another project is filed in that project's
tracker, not in the one that suffers from it. `speconaut-mindtape-skew-guard`
named no paogen file at all; it is now speconaut's
`keep-the-embedded-mindtape-in-step-with-the-installed-mt` and retired here.
`speconaut-mindtape-config-skew` records where it went. This belongs in
`AGENT.md` once `agent-guide-is-nine-lines-from-its-own-cap` makes room.

## What the owner still owes a decision on

- **Webhooks** — skippable, or a decision that a document carrying them cannot
  be generated. The refusal's own argument is in
  `UnsupportedKeywordScanner::webhookFailures()`: generating the `paths` half
  and saying nothing is an omission nobody asked for, and `$skip` names
  operations under `paths` and components under `components`, so there is
  nothing for a consumer to name. That argument is exactly right about the
  default and says nothing about whether the name should exist. Nothing about
  a webhook makes the `paths` unrepresentable. Recommendation and its full
  argument are in the task; it stays `proposed` until ruled.

## Next session

**Emitted output is the scheduling constraint.** 7,242 committed files, GitHub
alone 5,953. Two agents regenerating from different bases produce a conflict no
one can resolve by hand — three of the previous session's merge conflicts came
from exactly that. So: at most one agent touching `examples/*/generated` at a
time, and its partner strictly outside `src/Generator` and `examples/`.

Wave 1 — `merge-allof-members-into-one-model` (generator; 19 skips and the 9
widened operations) alongside both decision tasks in one agent (truth only).

Wave 2 — `a-union-request-body-takes-a-union-parameter` (generator; 27 skips)
alongside `gate-freshness-misses-the-files-linecop-lints` (scripts only).

Wave 3 — `support-the-parameter-shapes-real-documents-use` plus
`ref-path-parameter-to-a-non-scalar-component-is-ungated` in one agent, since
both need the same reference resolution in `ParameterShape` and the second
task's own criterion forbids a second resolver — alongside
`agent-guide-is-nine-lines-from-its-own-cap` (docs only, after wave 2's
`gate-fresh.inputs` change, so the new file lands in the right input set).

Wave 4, if the budget holds — `a-union-response-selects-its-branch` plus
`a-media-type-with-no-schema-takes-a-raw-body` in one agent, alongside
`binary-format-advisory-fires-on-a-format-that-now-drives-behaviour`.

That is nine tasks and it takes the skip list from 78 to roughly zero.

**Deliberately not in this session.** `typed-error-responses` (the envelope)
and `name-inline-schemas-by-operation-and-status` are one change in two
tasks — the naming exists because the envelope makes multiple typed responses
per operation universal — and both rewrite every generated method. They should
land together, after the skip list is at zero, so the trees regenerate once
over the final surface rather than three times. The envelope is difficulty 8
and is not Sonnet work.

**The release track is the last session, by the owner's instruction.** Rename,
then the runtime to Packagist, then the generator, then the kilbil extraction,
then the v0.1 criteria. In that order, because each one's mistake is cheaper to
find before the next repeats it. The rename is largely mechanical once its one
open string is confirmed — Rector plus two `composer.json` autoload maps plus a
full regeneration — so it suits a cheap model; the publishing steps are the
owner's, since they need a Packagist account and a new public repository.

## Standing hazards

Everything under that heading in `session-resume-260803b.md` still applies —
linecop's 250/300 caps, `just lint-rector` never bare `rector`, the stale
`build/cache/phpstan`, `chronic` masking sibling failures, `php` not `python3`,
`git stash push -u` never `git checkout --`, `composer.lock`'s `dev-<branch>`
version field, and grepping `truth/specs/` whenever a change makes a construct
representable. Two to add:

- `composer dump-autoload` after any merge that touches the autoload map. Six
  tests failed on an integrated tree with `Class ... does not exist` purely
  because a checkout's generated autoloader was stale.
- Writing a file under `truth/notes/` invalidates a recorded gate pass, because
  `gate-fresh.inputs` hashes `truth` and excludes only `truth/tasks`. Write the
  note first, then run `scripts/gated-check`, then flip. This is the defect
  `gate-freshness-misses-the-files-linecop-lints` fixes.
