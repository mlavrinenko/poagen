# Agent guide for paogen

## Release sequencing — read ROADMAP.md first

[`ROADMAP.md`](ROADMAP.md) at the repo root is the **ordered queue of
work until paogen ships v0.1**. Before starting any task, check the
roadmap:

- Pick up the next `[ ]` item in the earliest unfinished phase. Do
  *not* skip ahead unless the roadmap explicitly permits it.
- When a task completes (status `done` in the truth tree), tick its
  checkbox in `ROADMAP.md` **in the same commit** that flips the
  status.
- New tasks, withdrawn tasks, and re-sequencing all go through
  `ROADMAP.md` edits — see the "How to update this roadmap" section
  of that file for the rules.
- The roadmap retires on the `0.1.0` tag. Post-v0.1 follow-ups live
  in its "Post-v0.1 follow-ups" section until then.

Drift between `ROADMAP.md` and `speconaut status` is a bug. Fix
whichever is wrong, do not paper over it.

## Workflow

- **Spec-first.** Use the `speconaut-workflow` skill before any change to
  `src/` or `truth/`. Specs live in `truth/specs/*.typ`; decisions in
  `truth/decisions/*.typ`. The `truth/` directory is the source of truth —
  if code and spec disagree, fix the spec first, then re-confirm.
- **Conventional commits**, English. No `Co-Authored-By` lines.

## Quality gates (`just check`)

- **PHPStan**: `level: max` with `phpstan-strict-rules`,
  `phpstan-deprecation-rules`, and bleeding-edge config — see ADR-004.
- **Linecop**: enforced on `src/**`. Exempt: `tests/fixtures/**`,
  `vendor/**`, `build/**`, `tests/generated/**`. Configured in
  `.linecop.yaml`.
- **php-cs-fixer + rector** must run cleanly.
- **speconaut**: `just check-specs` validates the truth tree;
  `just check-generated-tests` enforces no drift in generated PHPUnit
  stubs.

When the linter complains about formatting, run `just format` before
hand-editing.

## Generated-code policy

- The generator's output lives under directories named `Generated/`. They
  are **never hand-edited**.
- All user customisation lives in either:
  - the user's `paogen.php` `Profile` (project-level config), or
  - attributes on the user's own value objects (`#[BindsFormat(...)]`
    et al.).
- See ADRs 001–003 for the rationale.

## Where things live

| Topic | Location |
|---|---|
| Behaviour specs | `truth/specs/*.typ` |
| Architectural decisions | `truth/decisions/*.typ` |
| Domain entities | `truth/domain/*.typ` |
| Implementation tasks | `truth/tasks/*.typ` (when present) |
| Long-form notes | `truth/notes/*.md` (limitations and design-exploration write-ups — decisions belong in `truth/decisions/`) |
| Review archives | `truth/reviews/*.md` (historical review passes preserved verbatim) |
| Real-world OpenAPI fixtures | `tests/fixtures/schemas/` |
| Sample profiles | `tests/fixtures/profiles/` |
| Golden generated trees | `tests/fixtures/generated/<vendor>/` |

## Environment

- PHP 8.4 via devbox (`devbox shell`); see `devbox.json`.
- speconaut binary expected on `$PATH`. If your install rebuilds on every
  invocation, point at a prebuilt binary directly — see the project
  Justfile for how the recipes invoke it.
- *Always invoke speconaut through `devbox run -- speconaut …`* (or via
  `just …` recipes that already do so). The in-tree
  `~/projects/home/speconaut/target/{debug,release}/speconaut` binary
  is frequently older than the system install and will reject
  currently-valid specs with confusing `unknown variable:` errors —
  do not reach for it as a fallback.

## When a dependency is broken, fix the dependency first

paogen depends on speconaut (core + PHPUnit adapter). If a speconaut-
side bug blocks routine paogen work — `lock` refuses a clean change,
`status` misreports drift, codegen produces wrong output, an adapter
emits bad stubs — do *not* route around it inside paogen. Stop paogen
work before any hand-edit or workaround, then:

+ *File a focused task in the owning repo* (see "Task placement"
  below), with the reproducible example taken from the paogen session
  that surfaced the problem.
+ *Fix the dependency there.* Switch `cwd` to
  `~/projects/home/speconaut` (or the relevant adapter path),
  implement the fix under its own spec-first workflow, land a green
  build, and commit.
+ *Return to paogen* and re-run the blocked workflow. If it is now
  green, proceed. If it is not, that is another dependency bug — file
  again.

This is not optional. A paogen change built on a hacked-around
dependency is a landmine for the next session.

## Workflow hazards — stop and escalate

Some failure modes signal that the tooling is out of step with reality,
not that your change is wrong. Do not hack around them.

- *Never hand-edit `.speconaut/state.lock`.* If `speconaut lock --approve`
  refuses a routine change, stop. Do not compute sha256 / zstd / base64
  snapshots by hand, and do not `sed` over trace hashes. File a task in
  the repo that owns the fix (see "Task placement" below), report to the
  user, and pause until it is resolved.
- *Never edit generated trees by hand.* Files under `Generated/`, under
  `tests/generated/*Test.php`, or under any `speconaut`-owned artifact
  are produced by tooling. If the tool output is wrong, fix the tool,
  not the output.
- If `just check`, `just check-drift`, `speconaut lock`, or
  `speconaut status` fails in a way that seems to *expect* you to patch
  generated state by hand, that is a workflow abomination. Stop, file
  upstream, ask.

## Task hygiene

- *One issue per task.* If you identify two problems, write two tasks,
  even if they were surfaced by the same symptom.
- *Tasks live in the repo that owns the fix:*
  - paogen behavior / specs: `~/projects/home/paogen/truth/tasks/`
  - speconaut core (engine, `lock`, `status`, `check`, CLI):
    `~/projects/home/speconaut/truth/tasks/`
  - speconaut adapter behavior (e.g. PHPUnit codegen, Rust codegen):
    `~/projects/home/speconaut/adapters/<adapter>/truth/tasks/`
  - Cross-adapter protocol: `~/projects/home/speconaut/adapter-truth/`.
    Check `ls ~/projects/home/speconaut/` first — the layout evolves.
- *Every task carries a reproducible example.* The exact commands to
  run, the observed output (copied, not paraphrased), the expected
  output, and the file:line references the reader needs. A task a
  reader has to re-derive to understand is a task that will be
  deprioritised forever.
- *Use `~/` paths, not bare relative paths.* `~/projects/home/paogen`
  is unambiguous across sessions and agents; `the paogen repo` or
  `./truth/specs/` is not.

## Reporting back

When you finish a chunk of work, say concretely what changed and where.
Quote file:line references. Do not summarise in the passive voice. If
something was blocked or worked around, say so explicitly in the same
breath — do not bury it.
