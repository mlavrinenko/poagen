# Agent guide for paogen

## Check the artifact, not the summary

Guidance here has outlived its facts four times, and each time it was right
when written. This file told agents the in-tree speconaut build was stale when
the system install *was* that build. The `Justfile` blamed four disabled
recipes on a mindtape parser when the cause was an unresolvable cargo
workspace. A spec asserted a seven-parameter sub-client constructor months
after it became two. `.speconaut/config.toml` claimed ~140 code references
where a grep found 32. Each was believed because it was written down.

**Before you enforce or rely on a rule from this file — or any doc, decision,
task or comment here — read the artifact it describes.** Run the command. Open
the config. Check the binary. A stale sentence reads exactly like a current one.

Found a false claim? Fix it in the same change that discovered it and say so in
your report. Routing around it silently is how this list got to four.

## What paogen is trying to be

Read `truth/vision.typ` before your first task. It describes what consuming an
HTTP API from a project that uses paogen should feel like, and it links the
seven goals that judge whether we got there. Every goal carries an acid test
that can be run rather than argued about.

Short version: a consumer points paogen at the schema their vendor published,
gets a typed client they never edit, and extends it from their own code rather
than by patching ours. Everything below serves that.

## Environment

PHP 8.4 via devbox; `composer install`, never `composer update` — the lockfile
is committed so every checkout gates on the same phpstan (2.2.7), rector
(2.5.9), php-cs-fixer and phpunit.

A fresh worktree needs both before any gate will run:

```
devbox install
composer install
devbox run -- just check
```

`devbox run -- <cmd>` keeps the full dev-shell PATH (`bin/`, `vendor/bin/`, the
devbox profile). So does `direnv exec . <cmd>`. An explicit PATH works too if
you want no wrapper:

```
PATH="$PWD/.devbox/nix/profile/default/bin:$PWD/vendor/bin:$PATH" just check
```

### Two traps that cost real time

A third one used to live here — rector dying on a DI container compiled by some
other checkout, because it pins that cache to `sys_get_temp_dir()` and every
worktree on the box shares it. The `Justfile` now exports a per-checkout
`TMPDIR` and creates it, so the gate runs clean from a cold tree with nothing
set in your environment. It is recorded here only so the symptom is
recognisable if you meet it outside `just`: an opaque `ProcessPool.php line 30:
Process "<random>" not found`, which means a stale cache, not a broken change.

**Build any `$PWD`-based PATH *after* you `cd`, never before.** There are
usually several paogen worktrees live at once, each with its own `vendor/`. A
PATH fragment expanded in the wrong directory silently runs another worktree's
phpstan against this one's source and reports a clean result. Check `pwd` first
and pin absolute paths.

**Never pipe a gate into `head`, `tail`, or anything else when you care whether
it passed.** The pipeline reports the last command's status, so a red gate reads
as exit 0 — verified on `linecop`, which exits 1 directly and 0 through `| head`.
Redirect to a file and echo `$?`.

### speconaut and mt

Both are on the system PATH. `speconaut` is a nix shim at
`/etc/profiles/per-user/tank/bin/speconaut`: it defaults `--root` to your cwd
when you pass none, then execs `~/projects/home/speconaut/target/debug/
speconaut`, `cargo build`-ing it first if absent. The system install and the
in-tree debug build are the same binary — there is no "newer" one to prefer,
and rebuilding speconaut in its own repo changes what paogen sees immediately.

`speconaut check` and every `mt` command need nothing else. `generate-tests`,
`status`, `lock` and `diff` spawn the PHP adapter (`speconaut-php-phpunit`) and
need `php` on PATH — from a bare shell they fail with `env: 'php': No such file
or directory` or a bare `Broken pipe`.

## Quality gates (`just check`)

`just check` is `lint test check-specs`. Lint runs php-cs-fixer, PHPStan on
`bin`/`src`/`tests`, PHPStan on the generated fixtures and example trees,
rector, and linecop, in parallel.

- PHPStan runs at `level: max` with `phpstan-strict-rules`,
  `phpstan-deprecation-rules`, `shipmonk/dead-code-detector` and bleeding-edge,
  in two tiers held to different absolutes — see the
  `analysis-runs-at-maximum-strictness` standard. `phpstan-generated.neon`
  analyses the emitted tree with no baseline, no `excludePaths` and no
  `ignoreErrors` at all: a finding there is fixed in the emitter, never
  annotated away in the output. `phpstan.neon.dist` analyses the generator and
  permits an exemption only where the tool is provably blind, each one carrying
  an inline comment naming the blind spot. Adding an exemption for a real
  finding is forbidden.
- Linecop enforces line limits across the whole repo, not just `src/` —
  `.linecop.yaml` excludes `vendor`, `build`, `.devbox`, `.git`,
  `tests/generated`, `tests/fixtures` and `examples`, and caps PHP at 250 lines
  and **Markdown at 300**. That cap covers this file, `README.md` and
  `CONTRIBUTING.md`. Read the config before writing and split up front rather
  than refactoring after the gate trips.
- `just format` before hand-fixing style complaints.

`just check-specs` runs `speconaut check truth/` straight from the repo root,
exiting 0 with `All specs valid (4 features)` and no warnings. There is no
longer any reason to copy the tree elsewhere to validate it.

`check-drift` and `check-generated-tests` stay **outside** the gate, blocked on
data rather than wiring: both need `tests/generated/manifest.json`, which only a
real `generate-tests` run produces, and that run means accepting ~200 outstanding
`Implement:` stubs and 149 orphaned-step warnings — `implement-the-outrun-step-
bodies` owns those. Read each recipe's own comment before touching either. For
the same missing manifest, `speconaut status`, `lock` and `diff` all hard-error
today with `failed to resolve traces via TraceProvider`. Expected and known
(`refresh-the-speconaut-lockfile`); not something your change broke.

`just check-examples` is deliberately outside the gate too. It reports each
example as passing, drifting, or expected-failure, and treats a stale
expected-failure marker as an error. Broken examples are committed on purpose,
as targets for upcoming work.

## The knowledge tree

`truth/` is the source of truth. If code and spec disagree, fix the spec first,
then re-confirm. Artifacts are classified by filename sub-extension, not by
directory — the folder layout is a convenience and the suffix is what counts.

| Kind | Filename | What it is |
|---|---|---|
| Vision | `truth/vision.typ` | Singleton narrative root linking every goal |
| Goal | `<slug>.goal.typ` | An outcome plus an acid test that can be run |
| Standard | `<slug>.standard-<yymmdd>.typ` | A rule decisions cite. Slot-only — the rule lives in `rule:`, never in a body |
| Decision | `<slug>.decision-<yymmdd>.typ` | A choice, its options, and its consequences |
| Feature | `<slug>.feature-<yymmdd>.typ` | Behavioural scenarios |
| Context | `<slug>.context.typ` | Bounded-context domain vocabulary |
| Task | `<slug>.task-<yymmdd>.typ` | MindTape task. Discovered automatically |

Every artifact except tasks must be `#include`-d in `truth/main.typ`. A file
that is not included fails `speconaut check` with `file not included`.

Two rules worth internalising before you write an artifact:

- **An accepted decision cites at least one goal and at least one standard**,
  or declares `process-only:` with a reason. A goal no decision serves is
  unrealised; a decision serving no goal is drift.
- **Every scenario step must reference a domain entity** wrapped in `#a()`,
  `#an()`, `#the()`, `#v()` or their capitalised forms, or the check fails with
  `domain-ref missing`. Do not bolt an irrelevant entity onto a step to satisfy
  the checker — that writes prose which lies about what is being tested. If a
  step cannot honestly reference one, say so rather than inventing.

Prose rules that will fail your check: no comment above the first `#show:`
(`header-comment`); no duplicate article (`a #a(Model)` — `#a()` already
supplies it); no misplaced modifier (`the same #a(Schema)` must be
`#the([same], Schema)`). `speconaut fix truth/` rewrites the last two in place;
the header-comment one is yours to remove.

Long-form notes live in `truth/notes/*.md`, review archives in
`truth/reviews/*.md`. Decisions do not belong in either.

## Tasks are MindTape, and the queue is `mt`

The backlog lives in `truth/tasks/` as one MindTape task per file. `mt ls` is
the queue. `ROADMAP.md` is a release checklist that retires on the `0.1.0` tag,
not a work queue — when the two disagree, `mt` wins.

```
mt ls                      # open work
mt ls '!terminal' --sort priority:desc
mt ls @wip                 # what is in flight — keep this at one
mt add -f values.json --name <slug>.task-<yymmdd>
mt flip wip truth/tasks/<slug>.task-<yymmdd>.typ
```

Resolve tasks by path. `mt ls` prints a short handle per row and `mt flip`
documents accepting one, but `mt eval` takes a path only and slug resolution
wants the full `.task-<yymmdd>` stem — a path always works.

This project runs MindTape's `gated` preset, which means:

- Four sections are required on any non-terminal task: Summary, Acceptance
  criteria, Non-goals, Files. Acceptance criteria are conditions someone else
  can check without asking you.
- `done` is reachable only from `needs-review`. No run of work closes itself.
  If you did the work, flip to `needs-review` and let a human close it. This is
  deliberate — agents report success they have not achieved and do not catch it
  themselves.
- `blocked`, `failed` and `cancelled` require a note saying why.
- A leftover review comment in a task file fails `mt check`.

`difficulty` scores judgment required, not size: 0–2 mechanical, 3–5 local
judgment, 6–8 cross-cutting design, 9 the approach itself is the open question.
It is the routing signal for which model tier should pick the task up.

## Commits

Conventional Commits, English, no `Co-Authored-By`. Every commit carries a
`Refs:` trailer naming the task slug — the filename stem without the
`.task-<yymmdd>.typ` suffix. One trailer line per task. See CONTRIBUTING.md.

Work with no task behind it needs a task first.

## Generated-code policy

Output under `Generated/` is never hand-edited. There is no protected region,
no marked insertion point, no inheritance hook — see the
`generated-types-are-total` standard. If output is wrong, fix the emitter.

All consumer customisation lives in the `paogen.php` `Profile` or in attributes
on the consumer's own value objects. Guidance is data paogen reads, never code
paogen runs — see `guidance-is-data-not-code`. Delete every bit of guidance and
generation still succeeds, producing a client that is less pleasant and no less
correct.

## Workflow hazards — stop and escalate

These signal that tooling is out of step with reality, not that your change is
wrong.

- **Never hand-edit `.speconaut/state.lock`.** If `speconaut lock` refuses a
  routine change, stop. Do not compute hashes by hand or `sed` over trace
  values. File upstream and pause.
- **Never edit generated trees by hand** — `Generated/`,
  `tests/generated/*Test.php`, or any tool-owned artifact.

  `tests/generated/*Steps.php` is the exception, and it says so in its own
  header: "This file is yours — speconaut only appends new step stubs." Those
  files are scaffolded once and then written by hand, and `phpstan.neon.dist`
  treats them as hand-written. Editing a step *body* is normal work. Adding or
  renaming step *methods* is not — those come from the specs.

  Append-only is measured, not assumed: regenerating into a scratch copy adds
  202 `Implement:` stubs and removes **zero** lines from any `*Steps.php`, while
  rewriting every `*Test.php` (hundreds of lines removed), which speconaut owns.
  A regeneration cannot destroy a hand-written body — but do it in a scratch
  copy anyway, since the added stubs fail the suite until
  `implement-the-outrun-step-bodies` lands.
- If a gate fails in a way that seems to *expect* you to patch generated state
  by hand, that is a workflow abomination. Stop, file upstream, ask.

## When a dependency is broken, fix the dependency first

paogen depends on speconaut (core plus the `php-phpunit` adapter) and on
MindTape. If a dependency-side bug blocks routine work, do not route around it
inside paogen. Stop before any hand-edit or workaround, then file a focused task
in the owning repo with the reproducible example from the session that surfaced
it, fix it there under that repo's own workflow, land green, and return. A
paogen change built on a hacked-around dependency is a landmine for the next
session.

## Task placement

One issue per task. Two problems surfaced by one symptom are two tasks.

- paogen behaviour and specs: `~/projects/home/paogen/truth/tasks/`
- speconaut core **and its adapters**: `~/projects/home/speconaut/truth/tasks/`
  — one flat root. `adapters/speconaut-php-phpunit/` and
  `adapters/speconaut-rust/` carry no task tree of their own.
- MindTape: `~/projects/home/mindtape/truth/tasks/`

Check `ls ~/projects/home/speconaut/` first — the layout evolves.

Every task carries a reproducible example: the exact commands, the observed
output copied rather than paraphrased, the expected output, and the references
a reader needs. A task someone has to re-derive to understand is a task that
gets deprioritised forever. Use `~/` paths, not bare relative ones.

## Reporting back

Say concretely what changed and where, with `file:line` references. Not the
passive voice. If something was blocked or worked around, say so in the same
breath rather than burying it — and if you could not verify something, say that
too instead of implying you did.
