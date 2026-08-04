# Agent guide for paogen

This file is the entry point — read it before your first task. Deep,
reactive-lookup material split out to keep both files under linecop's
Markdown cap: the OpenAPI parser's four lying accessors, two environment
traps (`TMPDIR`, PATH ordering, piping a gate's exit status), and the
PHPStan/rector/php-cs-fixer gate traps all live in `AGENT_HAZARDS.md`. Read
it before touching `src/`, `runtime/src/` or `tests/`, or when a gate goes
red in a way this file doesn't explain.

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
`bin`/`src`/`runtime/src`/`tests`, PHPStan on the generated fixtures and
example trees, rector, linecop, and both jscpd duplication tiers, in parallel.

- The PHPStan two-tier setup, the reflection-only-fixture triple-tool trap,
  and the rector/PHPStan loop are gate traps measured the expensive way — see
  `AGENT_HAZARDS.md`'s "Quality-gate traps" before debugging a red lint run.
- Linecop enforces line limits across the whole repo, not just `src/` —
  `.linecop.yaml` excludes `vendor`, `build`, `.devbox`, `.git`,
  `tests/generated`, `tests/fixtures` and `examples`, and caps PHP at 250 lines
  and **Markdown at 300**. That cap covers this file, `AGENT_HAZARDS.md`,
  `README.md` and `CONTRIBUTING.md`. Read the config before writing and split
  up front rather than refactoring after the gate trips.
- `just format` before hand-fixing style complaints.

`just check-specs` runs `speconaut check truth/` straight from the repo root,
exiting 0 with `All specs valid (4 features)` and no warnings. There is no
longer any reason to copy the tree elsewhere to validate it.

`check-drift` and `check-generated-tests` are **in** the gate as of 2026-07-31,
and this paragraph said the opposite until then. They were blocked on data
rather than wiring: both need `tests/generated/manifest.json`, which only a real
`generate-tests` run produces, and that run appended ~200 `Implement:` stubs and
149 orphaned-step warnings. `implement-the-outrun-step-bodies` cleared both, the
manifest is committed, and `speconaut status`, `lock` and `diff` all resolve
traces now. Adding a scenario therefore means running `speconaut generate-tests`
and implementing its stubs, then `speconaut lock`, in the same change — leave
either out and the gate is red. Read each recipe's own comment before touching
it.

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

`speconaut check truth/` parses every artifact in about a second — run it
directly after any `truth/` edit rather than waiting to hit the failure inside
a `just check` that takes minutes. It also catches something linecop won't:
Typst reads a bare `$` in prose as opening math mode, so an unbackticked PHP
sigil in a task body fails with `eval error: unclosed delimiter`. Because
`truth/tasks` is excluded from the freshness hash, that failure surfaces to
whoever runs the gate next, not to whoever wrote it — backtick every sigil.
The exclusion itself is filed as `a-malformed-task-artifact-records-as-fresh`;
this entry is the workaround, not the fix.

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
- `done` is reachable directly from `wip`, gated by a machine check rather than
  a human state: run `scripts/gated-check`, not a bare `just check`, before
  flipping — the `[[on.flip]]` predicate refuses without a freshly recorded
  pass. A `needs-review` state shipped originally and was removed 2026-08-01
  once it queued 38 already-shipped tasks against one reviewer; see
  `review-gate-must-be-mechanical`.
- `blocked`, `failed` and `cancelled` require a note saying why.
- A leftover review comment in a task file fails `mt check`.
- A gate pass covers only the tree it ran against, not whatever lands after
  it. Run the gate as the last thing before calling work done, after every
  commit that will be part of it — including a status-flip commit — not
  before one. Recording a pass and then committing on top of it, trusting the
  earlier pass to cover the new commit, is how a broken artifact reached
  `main` on 2026-08-03; the freshness record did not catch it because the
  file was excluded from its inputs.

`mt` on `PATH` rebuilds the mindtape checkout from source on every
invocation. When that checkout fails to compile — an uncommitted dependency
edit was enough on 2026-08-03 — every subcommand exits 101, `mt ls` and
`mt check` included, and nothing about paogen is at fault. Edit task
artifacts by hand instead — the format is plain Typst — and validate with
`speconaut check truth/`; run `scripts/gate-fresh is-fresh` directly for the
freshness check `mt`'s own `[[on.flip]]` predicate would otherwise run.

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

`Generated/` imports only from `runtime/`, this repo's second composer
package (`mlavrinenko/paogen-runtime`) — see
`runtime-ships-as-a-separate-package`. Consumers install it as a normal
dependency and the generator itself only as `require-dev`; anything the
generator needs (the parser, the code printer, the differ) belongs in `src/`,
never in `runtime/src/`.

Every emitted file says so itself, in a header naming the profile it came from
and the `paogen generate <profile>` that reproduces it, so the rule travels with
the artifact instead of living only here. Nothing is made read-only: git keeps
no write bit through a clone, so the barrier would exist on one machine only —
see `a-header-not-a-chmod`. The header is the whole mechanism, which is why an
edit under `Generated/` is caught by a reader rather than by the filesystem.

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

File a task in the tracker of the project it fixes, not the project the
symptom surfaced in. `speconaut-mindtape-skew-guard` sat here naming no paogen
file at all; it was retired and refiled as speconaut's
`keep-the-embedded-mindtape-in-step-with-the-installed-mt`, with
`speconaut-mindtape-config-skew` left behind pointing at where it went. A task
filed against the wrong repo is invisible to whoever can fix it and clutters
whoever cannot.

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
