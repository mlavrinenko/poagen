# Roadmap — paogen v0.1

> **This is a release checklist, not the work queue.** The queue is
> MindTape: run `mt ls`. Where the two disagree, `mt` wins. This file
> records what has to be true before a `0.1.0` tag, and retires on that
> tag. Closing it out is tracked as `v01-release-exit-criteria`.
>
> Two things below are now out of date and left in place as history
> rather than silently rewritten. OpenAPI 3.1 is no longer a post-v0.1
> follow-up — the `openapi-31-through-a-maintained-parser` decision
> supersedes that, because every schema worth generating against is 3.1.
> And the `T-NNN` identifiers predate the move to task slugs; the
> corresponding artifacts are `truth/tasks/<slug>.task-<yymmdd>.typ`.

This file was **derived** from the truth tree and the 2026-04-18
pre-release review at
[`truth/reviews/2026-04-18-pre-release-review.md`](truth/reviews/2026-04-18-pre-release-review.md).

**Scope policy.** v0.1 is the first consumable release, not feature
parity with mature generators. We ship what makes the pipeline
*correct*, *type-safe*, and *pleasant* to use on real schemas. Mutation
testing remains an explicit **post-v0.1** follow-up.

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

- [x] **ADR-009 confirm** — Accepted: single generic `Generated\ApiException` shape. See `truth/decisions/009-error-response-policy.typ` (status: accepted).
- [x] **T-012** — Throw typed `ApiException` on non-2xx responses.
- [x] **T-014** — Surface `securitySchemes` (`apiKey`, `http bearer`) as constructor / method arguments; leave `basic`, `oauth2`, `openIdConnect` as `draft`.
- [x] **T-011** — Support `application/x-www-form-urlencoded` request bodies; stub `multipart/form-data` with a throwing placeholder rather than silent skip.

## Phase 4 — Packaging / DX

- [x] **T-016** — Silence `cebe/php-openapi` PHP 8.4 deprecation noise (composer-patch or upstream pin). *Decoupled from 3.1 by ADR-008.*
- [x] **T-022** — Byte-stability integration test against Petstore (runs generator twice; asserts identical output and match against the golden tree).
- [x] **T-019** — `paogen generate` grows `--output`, `--dry-run`, `--diff` flags.
- [x] **T-020** — Dropped codecov entirely (no meaningful threshold on a codegen project whose logic is exercised through generated fixtures). ADR-004 updated.

## Phase 5 — Real-world schema shakedown (emerged 2026-04-19)

Landing [`examples/`](examples/) made one pre-release-review item
concrete: the ADR-005 validation-tier schemas (DigitalOcean, GitHub)
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
*ugly* and must be replaced before v0.1 ships. ADR-010 supersedes
ADR-007's representation choice: phpdoc becomes authoritative for
structural types, attributes carry non-structural metadata, and a
new runtime `Marshaller`/`Hydrator` drives (de)serialisation via
`phpstan/phpdoc-parser`. Runtime performance is explicitly
deprioritised — see ADR-010 "Scope + priority policy".

- [x] **T-027** — Audit `truth/specs/**` and `truth/decisions/**` for
  performance-flavoured passages superseded by ADR-010; revise
  wording. Supersede-mark ADR-007's representation section. No code
  changes.
- [x] **T-028** — Implement ADR-010 end-to-end: runtime attribute
  classes, `Marshaller`, `Hydrator`, ModelEmitter rewrite,
  ClientEmitter rewrite, `phpstan/phpdoc-parser` added to runtime
  composer require, golden trees regenerated, specs updated.
  Prereq: T-027.
- [x] **T-029** — Marshaller/Hydrator `token_get_all` phpdoc fallback
  for environments where opcache strips comments
  (`opcache.save_comments=0`). Filed as the documented dirty-fix
  follow-up from T-028.
- [x] **T-030** — Generator-time error for `oneOf` without
  `discriminator` (per ADR-010), with a profile-level discriminator
  override. `DiscriminatorEnforcer` fails the run for property-level
  ref unions without a `discriminator` after applying
  `Profile::$discriminators` overrides; `UndiscriminatedUnionException`
  carries the pointed remediation message. `Hydrator::branchFromStructure()`
  is gone — unions are discriminator-only. Composition fixture gains a
  discriminator on `Animal.creature`; the DigitalOcean / GitHub example
  trees are marked `.expected-failure` pending per-schema discriminator
  overrides (post-v0.1 follow-up).

## v0.1 exit criteria

All of the above checked, plus:

- [ ] `just check` green on PHP 8.4 with **zero** deprecation notices.
- [ ] Petstore golden fixture regenerated and committed after every scope change above.
- [ ] `speconaut status` shows **no** pending tasks listed in this document.
- [ ] README "known limitation: OpenAPI 3.1 not yet supported" note kept, linked to `truth/notes/openapi-3.1-gap.md` and ADR-008.
- [ ] `CHANGELOG.md` gains a `0.1.0` section.
- [ ] `composer.json` stability flipped to `stable`.

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

- **OpenAPI 3.1 support** — ADR-008 (`accepted`) defers the decision;
  the three options (swap parser, write 3.1→3.0 shim, fork) are
  catalogued at [`truth/notes/openapi-3.1-gap.md`](truth/notes/openapi-3.1-gap.md).
  When revisited, produce a prototype task, supersede ADR-008, then
  remove the README limitation note.
- **Mutation testing** — task 021 was retired as `done` without
  wiring infection; revisit once the code surface stabilises.
- **Validation-tier fixtures** — ADR-005 calls out DigitalOcean and
  the GitHub 3.0 bundled variant. Land post-v0.1 once the generator
  is proven on Petstore plus the items above.
- **`format: uuid`, `format: binary`** — file as a follow-up once a
  fixture needs them (see T-010 out-of-scope).
- **Coloured / filtered diff output** for `--diff` — see T-019
  out-of-scope.

## How to follow this roadmap

When picking up work in paogen:

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

This file retires on the `0.1.0` tag. At that point create
`ROADMAP-v0.2.md` (or similar) and prune `post-v0.1` items into the
new file's backlog.
