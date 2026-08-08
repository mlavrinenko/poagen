# Roadmap — poagen v0.1

> **Retired 2026-08-08.** This was a release checklist, never the work
> queue — MindTape (`mt ls`) always was, and remains the only one now.
> `v01-release-exit-criteria` closed this file out: every exit criterion
> in the section below is ticked, rewritten or dropped, with the reason
> written next to it rather than left in that task's commit message
> alone. The two open backlog items this file was still carrying with no
> MindTape task behind them — a built-in binding for `format: uuid` /
> `format: binary`, and coloured / path-filtered `--diff` output — are
> now `built-in-uuid-and-binary-format-bindings` and
> `coloured-and-path-filtered-diff-output`; see "Post-v0.1 follow-ups"
> below. This file's own closing rule (bottom of the file) says to create
> `ROADMAP-v0.2.md` and prune the backlog into it; that step is skipped
> on purpose, because the backlog already lives entirely in MindTape and
> a second copy of it in a new markdown file would be one more place to
> keep in sync. Kept in place rather than deleted, as the historical
> record of what v0.1 required and how each requirement was actually
> closed — `AGENT.md` and `README.md` both still point readers here for
> that history.
>
> Three things below were already out of date before this retirement and
> are left in place as history rather than silently rewritten. OpenAPI
> 3.1 is no longer a post-v0.1 follow-up — the
> `openapi-31-through-a-maintained-parser` decision supersedes that,
> because every schema worth generating against is 3.1. Mutation testing
> is no longer an open follow-up either — it is wired, measured, and
> deliberately kept out of `just check`; see
> `mutation-testing-stays-out-of-the-gate.decision-260802.typ` for the
> numbers behind that. And the `T-NNN` identifiers predate the move to
> task slugs; the corresponding artifacts are
> `truth/tasks/<slug>.task-<yymmdd>.typ`.

This file was **derived** from the truth tree and the 2026-04-18
pre-release review at
[`truth/reviews/2026-04-18-pre-release-review.md`](truth/reviews/2026-04-18-pre-release-review.md).

**Scope policy.** v0.1 is the first consumable release, not feature
parity with mature generators. We ship what makes the pipeline
*correct*, *type-safe*, and *pleasant* to use on real schemas. Mutation
testing is wired (`just mutate`) but runs outside `just check` — a full
run takes seven-plus minutes, well past this project's gate budget; see
`mutation-testing-stays-out-of-the-gate.decision-260802.typ`.

## Phase 1 — Release blocker + `ScalarBinding` foundation

Both tasks touch `runtime/src/ScalarBinding` (introduced by task 004).
Land 004 first; 010 is the first in-tree consumer.

- [x] **T-004** — Round-trip `BindsFormat` scalar value objects on send *and* receive. *(critical release blocker; `#[BindsFormat]` is unusable without it.)*
- [x] **T-010** — Built-in `\DateTimeImmutable` mapping for `format: date-time` and `format: date`.

## Phase 2 — Model Generator coverage holes

All P1-high, all independent, each closes a `mixed`-fallback branch in
`TypeResolver::resolve()`. Land one at a time, smallest surface first.

- [x] **T-009** — Emit OpenAPI enums as PHP 8.1 backed enums.
- [x] **T-013** — Emit inline nested object schemas as typed maps or synthesized `Generated/Model/*` classes.
- [x] **T-008** — Emit typed PHP for `oneOf` / `anyOf` / `allOf` composition.

## Phase 3 — Operation Generator coverage

- [x] **`error-response-policy` confirm** — Accepted: single generic `Generated\ApiException` shape. See `truth/decisions/error-response-policy.decision-260418.typ` (status: accepted).
- [x] **T-012** — Throw typed `ApiException` on non-2xx responses.
- [x] **T-014** — Surface `securitySchemes` (`apiKey`, `http bearer`) as constructor / method arguments; leave `basic`, `oauth2`, `openIdConnect` as `draft`.
- [x] **T-011** — Support `application/x-www-form-urlencoded` request bodies; stub `multipart/form-data` with a throwing placeholder rather than silent skip.

## Phase 4 — Packaging / DX

- [x] **T-016** — Silence `cebe/php-openapi` PHP 8.4 deprecation noise (composer-patch or upstream pin). *Decoupled from 3.1 by `openapi-31-strategy`.*
- [x] **T-022** — Byte-stability integration test against Petstore (runs generator twice; asserts identical output and match against the golden tree).
- [x] **T-019** — `poagen generate` grows `--output`, `--dry-run`, `--diff` flags.
- [x] **T-020** — Dropped codecov entirely (no meaningful threshold on a codegen project whose logic is exercised through generated fixtures). `quality-gates-at-maximum-strictness` updated.

## Phase 5 — Real-world schema shakedown (emerged 2026-04-19)

Landing [`examples/`](examples/) made one pre-release-review item
concrete: the `schema-fixture-policy` validation-tier schemas (DigitalOcean, GitHub)
aborted at code emission because the generator used raw OpenAPI
component names as PHP class identifiers. Phase 5 replaced the
hard-coded name handling with a pluggable pipeline (T-023) and then
exposed two further gaps surfaced while exercising DO and GitHub —
both filed as follow-up tasks the release cut must now sequence.

- [x] **T-024** — `examples/` folder with petstore, digitalocean, github, and the `just check-examples` recipe.
- [x] **T-023** — Pluggable OpenAPI → PHP name-normalisation strategies. Default pipeline (`RenamesNormaliser` → `PascalCaseSanitiser`) handles every DO and GitHub component; users compose their own strategies for anything exotic. All three examples pass `just check-examples`.
- [x] **T-025** — Parameter-name and operationId normalisation. `OperationId` and `ParameterName` join the `SymbolKind` registry (camelCased via the new `CamelCaseSanitiser`), `ResolvedParameter` keeps the raw wire key alongside the sanitised PHP identifier, the T-023 early-skip guards are gone, and `GenerationPlan::$skippedOperations` surfaces the residual skips on stderr. GitHub now generates 827 ops (was 0); DigitalOcean 525 (was 522).
- [x] **T-026** — Named scalar + top-level composition components resolve to real PHP types. `ComponentCatalog` classifies every `components.schemas` entry; scalars emit a `ScalarBinding` VO, `type: array` components emit a typed wrapper, top-level `oneOf`/`anyOf` emit a marker interface that inline-branch synths and `$ref`-branch Models `implements`. The DigitalOcean and GitHub golden trees now carry zero `class.notFound` errors under `phpstan-generated.neon`. Path-param `(string)` cast bugs against scalar-VO refs (surfaced by the new classes) filed separately as T-031.

## Phase 6 — Clean model output (emerged 2026-04-20)

A 2026-04-20 design review with the project owner concluded the
current Model output (`PROPERTY_MAP` const + `JsonSerializable`) is
*ugly* and must be replaced before v0.1 ships.
`attribute-and-phpdoc-driven-serialization` supersedes
`hydration-and-serialization-contract`'s representation choice: phpdoc
becomes authoritative for structural types, attributes carry
non-structural metadata, and a new runtime `Marshaller`/`Hydrator` drives
(de)serialisation via `phpstan/phpdoc-parser`. Runtime performance is
explicitly deprioritised — see
`attribute-and-phpdoc-driven-serialization` "Scope + priority policy".

- [x] **T-027** — Audit `truth/specs/**` and `truth/decisions/**` for
  performance-flavoured passages superseded by
  `attribute-and-phpdoc-driven-serialization`; revise wording.
  Supersede-mark `hydration-and-serialization-contract`'s representation
  section. No code changes.
- [x] **T-028** — Implement `attribute-and-phpdoc-driven-serialization`
  end-to-end: runtime attribute
  classes, `Marshaller`, `Hydrator`, ModelEmitter rewrite,
  ClientEmitter rewrite, `phpstan/phpdoc-parser` added to runtime
  composer require, golden trees regenerated, specs updated.
  Prereq: T-027.
- [x] **T-029** — Marshaller/Hydrator `token_get_all` phpdoc fallback
  for environments where opcache strips comments
  (`opcache.save_comments=0`). Filed as the documented dirty-fix
  follow-up from T-028.
- [x] **T-030** — Generator-time error for `oneOf` without
  `discriminator` (per `attribute-and-phpdoc-driven-serialization`), with
  a profile-level discriminator
  override. `DiscriminatorEnforcer` fails the run for property-level
  ref unions without a `discriminator` after applying
  `Profile::$discriminators` overrides; `UndiscriminatedUnionException`
  carries the pointed remediation message. `Hydrator::branchFromStructure()`
  is gone — unions are discriminator-only. Composition fixture gains a
  discriminator on `Animal.creature`; the DigitalOcean / GitHub example
  trees are marked `.expected-failure` pending per-schema discriminator
  overrides (post-v0.1 follow-up).

## v0.1 exit criteria

All of the above checked, plus — reconciled 2026-08-08 by
`v01-release-exit-criteria` against the tree as it actually stood, not the
2026-08-03 preliminary reading that task started from:

- [x] `just check` green on PHP 8.4 with **zero** deprecation notices.
  Verified 2026-08-08, not inferred from the exit status: ran `just check`
  in full (linecop, jscpd, cs-fixer, phpstan, rector, every `examples/*/`
  analysis, phpunit, the coverage floor, and all three `speconaut` steps),
  captured the complete output, and grepped it for `deprecat`
  case-insensitively. Zero matches. Exit status was also `0`, but that was
  never the claim this bullet makes — the grep is.
- [x] Petstore golden fixture regenerated and committed after every scope
  change above. Enforced, not remembered:
  `tests/Integration/ByteStabilityTest::testPetstoreGeneratorRunsAreByteIdenticalToEachOtherAndToTheGoldenTree`
  runs the generator twice against the Petstore profile and fails
  `just check`'s phpunit step the moment either run drifts from the
  committed golden tree or from each other (T-022).
- [x] *Rewritten.* Was: "`speconaut status` shows no pending tasks listed in
  this document." Task status never lived in `speconaut` — MindTape does,
  and the `T-NNN` → `truth/tasks/NNN-*.typ` mapping the original wording
  depended on predates the move to task slugs (see this file's intro note).
  Replaced by: no task any phase above names is open in `mt ls`. Verified
  2026-08-08: `mt ls ''` shows every task cited by number in Phases 1–4
  (004, 007–014, 016, 019, 020) and by number in Phases 5–7 (022–031) as
  `done`; every checkbox in Phases 1–7 above is already `[x]` and none of
  them regressed.
- [x] README describes OpenAPI 3.1 as supported and names the JSON Schema
  2020-12 constructs that abort by name (`const`, `prefixItems`,
  `unevaluatedProperties`, `contentMediaType`, plus a 3.1 `webhooks` entry) —
  matches `UnsupportedKeywordScanner`, not the old "not yet supported" note.
  `truth/notes/openapi-3.1-gap.md` is retired rather than kept current;
  `openapi-31-strategy` was already superseded by
  `openapi-31-through-a-maintained-parser`. Re-confirmed 2026-08-08: the
  four keywords and the README's wording still match
  `src/Generator/Emit/UnsupportedKeywordScanner.php`'s `KEYWORDS` constant
  exactly, `openapi-31-strategy.decision-260419.typ` still reads
  `status: superseded(2026, 7, 29)`, and `truth/notes/openapi-3.1-gap.md`
  is absent from the tree with no `#link` to it left in `truth/main.typ`.
- [x] `CHANGELOG.md` gains a `0.1.0` section. Done closing this file: the
  `[Unreleased]` section — everything shipped since `0.1.0` was last
  drafted, including the vendor rename, the `Envelope` return type, the
  parser swap, and the recursive `allOf` merge — is folded into
  `[0.1.0] - TBD`, reconciled against `git log` and `mt ls ''`'s closed
  tasks rather than against memory. See `CHANGELOG.md`.
- ~~`composer.json` stability flipped to `stable`.~~ *Dropped.*
  `minimum-stability: stable` already sat in both `composer.json` and
  `runtime/composer.json` before this bullet was ever reconciled — it
  governs composer's own dependency resolution, not paogen's maturity, so
  it was satisfied by accident rather than by intent and proves nothing
  about release readiness. The only reading that would mean something —
  tagging paogen `0.1.0` — has no target: paogen stays off Packagist on
  purpose (see `v01-release-exit-criteria`'s non-goals), and the runtime's
  own version is `publish-the-runtime-package-to-packagist`'s criterion,
  not this file's. A criterion that is either already true by coincidence
  or means nothing for the package it names is worse than no criterion —
  dropped rather than kept as a check that always trivially passes.

## Phase 7 — T-026 downstream residual (emerged 2026-04-20)

- [x] **T-031** — ClientEmitter routes scalar-VO / ScalarBinding path
  (and matching `oneOf`/`anyOf`) parameters through `toScalar()`.
  `RequestAssembler` consults the `ComponentCatalog` via the new
  `ParameterStringExpr` helper. The DigitalOcean and GitHub example
  trees no longer emit `cast.string` errors against `Model\*`
  classes; the residual `cast.string` wave is `mixed → string` from
  parameters whose schema resolved to `mixed` and belongs to a
  separate follow-up.

## Post-v0.1 follow-ups (not release-gating)

These are deliberately out of scope for the first tag. They are
tracked in the truth tree (ADRs / docs) but do **not** belong on
v0.1's critical path.

- ~~**OpenAPI 3.1 support**~~ — resolved: `swap-openapi-parser-for-31-support`
  landed 3.1 through `devizzent/cebe-php-openapi`, per
  `openapi-31-through-a-maintained-parser` (supersedes `openapi-31-strategy`).
  The README limitation note is gone and `truth/notes/openapi-3.1-gap.md` is
  retired rather than kept current. No longer a post-v0.1 follow-up — this
  file's intro note already said so. Kept here, struck through, as history
  rather than deleted — see this file's intro note.
- ~~**Mutation testing**~~ — resolved 2026-08-02, no longer an open
  follow-up. Task 021 was retired as `done` without wiring infection;
  `wire-mutation-testing` wired it, measured a 7-minute full run against
  `src/` and `runtime/src/`, and recorded the gate decision in
  `mutation-testing-stays-out-of-the-gate.decision-260802.typ`. Kept here,
  struck through, as history rather than deleted — see this file's intro
  note.
- ~~**Validation-tier fixtures**~~ — resolved: Phase 5's T-024 landed the
  `examples/digitalocean` and `examples/github` scaffolds this bullet asked
  for, and `clear-example-expected-failures` (done 2026-08-03) cleared both
  `.expected-failure` markers. Both examples generate cleanly with a
  committed `generated/` tree, re-confirmed 2026-08-08: no
  `.expected-failure` file remains under `examples/`, and `just check`'s
  `lint-phpstan-generated` step analyses both trees clean. No longer a
  post-v0.1 follow-up — kept here, struck through, as history rather than
  deleted, per this file's own convention above.
- **`format: uuid`, `format: binary`** — still open. Filed 2026-08-08 as
  `built-in-uuid-and-binary-format-bindings.task-260808.typ` while retiring
  this file, per T-010's own out-of-scope note.
- **Coloured / filtered diff output** for `--diff` — still open. Filed
  2026-08-08 as `coloured-and-path-filtered-diff-output.task-260808.typ`
  while retiring this file, per T-019's own out-of-scope note.

## How to follow this roadmap

*Historical.* This file is retired — see the note at the top. The two
sections below describe how it worked while it was live; `mt ls` is the
queue now, not this.

When picking up work in poagen:

1. **Read this file first.** It is the ordered queue. Do not start
   Phase 3 work while Phase 1 items are open unless you have an
   explicit reason and have updated this file to reflect it.
2. **Cross-check against `speconaut status`.** A task listed here as
   `[ ]` should be `proposed` (or `done` if the checkbox is ticked);
   one listed as `[x]` must be `done`. Drift between this file and
   the truth tree is a bug — fix whichever is wrong.
3. **Each task has a canonical spec file.** The `T-NNN` IDs map to
   `truth/tasks/NNN-*.typ`. That file has the definitive scope,
   acceptance criteria, and links to the spec / ADR the task
   traces to. This roadmap only summarises.
4. **Before starting a task:** invoke the `speconaut-workflow` skill
   per `AGENT.md`.

## How to update this roadmap

This file is a *working* document. It changes often. Rules:

- **Tick a checkbox only when the task's status in the truth tree is
  `done`.** Update both in the same commit (and the same lock pass).
- **Add a new task** by appending it to the correct phase. If the
  task should run *before* something else in the phase, place it
  there — order matters within a phase.
- **Remove a task** only when it is withdrawn (not when it is
  completed). Note the reason in the commit message and, if the
  reason is durable, in the owning ADR or a new one.
- **Re-sequence phases** when priorities shift. State the reason in
  the commit message. Do not silently reorder items.
- **Post-v0.1 follow-ups are append-only** during v0.1 work. Items
  only graduate *back into* the phases above by explicit decision.
- **Out-of-scope discoveries** (a task's body reveals a second
  problem) → file a *new* task, don't grow the existing one. Then
  add it here. This matches `AGENT.md`'s "one issue per task" rule.
- **Changes to this file are always commits, never worktree-only
  edits.** Conventional commit prefix: `docs(roadmap):`.

This file said it would retire on the `0.1.0` tag and create
`ROADMAP-v0.2.md` to hold the pruned backlog. It retired 2026-08-08
instead, closed by `v01-release-exit-criteria` against the exit criteria
above rather than against the tag event, and no `ROADMAP-v0.2.md` was
created — the backlog already lives entirely in MindTape (`mt ls`), and a
second copy of it here would be one more place to keep in sync. See the
retirement note at the top of this file. Nothing below this point is a
work queue any more, and this file does not get updated further; it stays
as the record of what v0.1 required and how each requirement closed.
