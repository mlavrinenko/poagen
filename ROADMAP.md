# Roadmap — paogen v0.1

This file is the **single source of truth for release-path sequencing**
until paogen ships its first tagged version. It is *derived* from the
truth tree (`truth/specs/*.typ`, `truth/decisions/*.typ`,
`truth/tasks/*.typ`) and the 2026-04-18 pre-release review at
[`docs/reviews/2026-04-18-pre-release-review.md`](docs/reviews/2026-04-18-pre-release-review.md).

**Scope policy.** v0.1 is the first consumable release, not feature
parity with mature generators. We ship what makes the existing
OpenAPI 3.0 pipeline *correct*, *type-safe*, and *pleasant* to use on
real schemas. OpenAPI 3.1 and mutation testing are explicit
**post-v0.1** follow-ups.

## Phase 1 — Release blocker + `ScalarBinding` foundation

Both tasks touch `src/Runtime/ScalarBinding` (introduced by task 004).
Land 004 first; 010 is the first in-tree consumer.

- [x] **T-004** — Round-trip `BindsFormat` scalar value objects on send *and* receive. *(critical release blocker; `#[BindsFormat]` is unusable without it.)*
- [ ] **T-010** — Built-in `\DateTimeImmutable` mapping for `format: date-time` and `format: date`.

## Phase 2 — Model Generator coverage holes

All P1-high, all independent, each closes a `mixed`-fallback branch in
`TypeResolver::resolve()`. Land one at a time, smallest surface first.

- [ ] **T-009** — Emit OpenAPI enums as PHP 8.1 backed enums.
- [ ] **T-013** — Emit inline nested object schemas as typed maps or synthesized `Generated/Model/*` classes.
- [ ] **T-008** — Emit typed PHP for `oneOf` / `anyOf` / `allOf` composition.

## Phase 3 — Operation Generator coverage

- [ ] **ADR-009 confirm** — Accept the proposed "single generic `Generated\ApiException`" shape, or supersede with a concrete alternative before T-012 starts. (Currently `status: proposed`.)
- [ ] **T-012** — Throw typed `ApiException` on non-2xx responses.
- [ ] **T-014** — Surface `securitySchemes` (`apiKey`, `http bearer`) as constructor / method arguments; leave `basic`, `oauth2`, `openIdConnect` as `draft`.
- [ ] **T-011** — Support `application/x-www-form-urlencoded` request bodies; stub `multipart/form-data` with a throwing placeholder rather than silent skip.

## Phase 4 — Packaging / DX

- [ ] **T-016** — Silence `cebe/php-openapi` PHP 8.4 deprecation noise (composer-patch or upstream pin). *Decoupled from 3.1 by ADR-008.*
- [ ] **T-022** — Byte-stability integration test against Petstore (runs generator twice; asserts identical output and match against the golden tree).
- [ ] **T-019** — `paogen generate` grows `--output`, `--dry-run`, `--diff` flags.
- [ ] **T-020** — Enforce a coverage threshold in CI (80% for `src/`) *or* drop codecov entirely. Pick one and update ADR-004.

## v0.1 exit criteria

All of the above checked, plus:

- [ ] `just check` green on PHP 8.4 with **zero** deprecation notices.
- [ ] Petstore golden fixture regenerated and committed after every scope change above.
- [ ] `speconaut status` shows **no** pending tasks listed in this document.
- [ ] README "known limitation: OpenAPI 3.1 not yet supported" note kept, linked to `docs/design/openapi-3.1-gap.md` and ADR-008.
- [ ] `CHANGELOG.md` gains a `0.1.0` section.
- [ ] `composer.json` stability flipped to `stable`.

## Post-v0.1 follow-ups (not release-gating)

These are deliberately out of scope for the first tag. They are
tracked in the truth tree (ADRs / docs) but do **not** belong on
v0.1's critical path.

- **OpenAPI 3.1 support** — ADR-008 (`accepted`) defers the decision;
  the three options (swap parser, write 3.1→3.0 shim, fork) are
  catalogued at [`docs/design/openapi-3.1-gap.md`](docs/design/openapi-3.1-gap.md).
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
