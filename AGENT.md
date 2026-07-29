# Agent guide for paogen

## What paogen is trying to be

Read `truth/vision.typ` before your first task. It describes what consuming an
HTTP API from a project that uses paogen should feel like, and it links the
seven goals that judge whether we got there. Every goal carries an acid test
that can be run rather than argued about.

The short version: a consumer points paogen at the schema their vendor
published, gets a typed client they never edit, and extends it from their own
code rather than by patching ours. Everything below serves that.

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
that is not included fails `speconaut check`.

Two rules worth internalising before you write an artifact:

- **An accepted decision cites at least one goal and at least one standard**,
  or declares `process-only:` with a reason. A goal no decision serves is
  unrealised; a decision serving no goal is drift.
- **Every scenario step must reference a domain entity** wrapped in `#a()`,
  `#an()`, `#the()`, `#v()` or their capitalised forms. Do not bolt an
  irrelevant entity onto a step to satisfy the checker — that writes prose
  which lies about what is being tested. If a step cannot honestly reference
  one, say so rather than inventing.

Prose rules that will fail your check: no comment above the first `#show:`; no
duplicate article (`a #a(Model)` — `#a()` already supplies it); no misplaced
modifier (`the same #a(Schema)` must be `#the([same], Schema)`).

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

Resolve tasks by path. Slug resolution wants the full stem including the
`.task-<yymmdd>` part, which is easy to get wrong; a path always works.

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

## Environment

PHP 8.4 via devbox. The dev-shell PATH does not survive a non-interactive
shell, so `devbox run -- <cmd>` will lose devbox-provided binaries and
`composer`-installed ones alike. Call them through an explicit PATH:

```
PATH="$PWD/.devbox/nix/profile/default/bin:$PWD/vendor/bin:$PATH" just check
```

`speconaut` and `mt` are on the system PATH and need no wrapper. Do not reach
for `~/projects/home/speconaut/target/{debug,release}/speconaut` as a fallback —
an in-tree build is frequently older than the system install and rejects
currently-valid specs with confusing `unknown variable:` errors.

Never pipe a gate command into `head`, `tail`, or anything else when you care
about whether it passed. The pipeline reports the last command's status, so a
red gate reads as exit 0. Redirect to a file and echo `$?`.

## Quality gates (`just check`)

`just check` is `lint test`. Lint is php-cs-fixer, PHPStan on `src/`, PHPStan on
the generated fixtures, rector, and linecop, run in parallel.

- PHPStan runs at `level: max` with `phpstan-strict-rules`,
  `phpstan-deprecation-rules` and bleeding-edge, in two tiers held to different
  absolutes — see the `analysis-runs-at-maximum-strictness` standard.
  `phpstan-generated.neon` analyses the emitted tree with no baseline, no
  `excludePaths` and no `ignoreErrors` at all: a finding there is fixed in the
  emitter, never annotated away in the output. `phpstan.neon.dist` analyses the
  generator and permits an exemption only where the tool is provably blind
  (reflection-only property reads, third-party rule-set limitations), each one
  carrying an inline comment naming the blind spot. Adding an exemption for a
  real finding is forbidden.
- Linecop enforces per-language line limits on `src/**`. Read `.linecop.yaml`
  before writing and split into modules up front rather than refactoring after
  the gate trips.
- `just format` before hand-fixing style complaints.

The speconaut recipes (`check-specs`, `check-generated-tests`, `check-drift`)
are currently **outside** this aggregate while the truth tree finishes
migrating to current speconaut. `rewire-speconaut-justfile-recipes` puts them
back. Until then, run `speconaut check truth/` directly.

`just check-examples` is deliberately outside the gate too. It reports each
example as passing, drifting, or expected-failure, and treats a stale
expected-failure marker as an error. Broken examples are committed on purpose,
as targets for upcoming work.

## Generated-code policy

Output under `Generated/` is never hand-edited. There is no protected region,
no marked insertion point, no inheritance hook — see the
`generated-types-are-total` standard. If output is wrong, fix the emitter.

All consumer customisation lives in the `paogen.php` `Profile` or in attributes
on the consumer's own value objects. Guidance is data paogen reads, never code
paogen runs — see `guidance-is-data-not-code`. Delete every bit of guidance and
generation still succeeds, producing a client that is less pleasant and no less
correct.

## When a dependency is broken, fix the dependency first

paogen depends on speconaut (core plus the PHPUnit adapter) and on MindTape. If
a dependency-side bug blocks routine work, do not route around it inside
paogen. Stop before any hand-edit or workaround, then file a focused task in
the owning repo with the reproducible example from the session that surfaced
it, fix it there under that repo's own workflow, land green, and return.

A paogen change built on a hacked-around dependency is a landmine for the next
session.

## Workflow hazards — stop and escalate

These signal that tooling is out of step with reality, not that your change is
wrong.

- **Never hand-edit `.speconaut/state.lock`.** If `speconaut lock` refuses a
  routine change, stop. Do not compute hashes by hand or `sed` over trace
  values. File upstream and pause.
- **Never edit generated trees by hand** — `Generated/`, `tests/generated/`, or
  any tool-owned artifact.
- If a gate fails in a way that seems to *expect* you to patch generated state
  by hand, that is a workflow abomination. Stop, file upstream, ask.

## Task placement

One issue per task. Two problems surfaced by one symptom are two tasks.

- paogen behaviour and specs: `~/projects/home/paogen/truth/tasks/`
- speconaut core: `~/projects/home/speconaut/truth/tasks/`
- speconaut adapters: `~/projects/home/speconaut/adapters/<adapter>/truth/tasks/`
- MindTape: `~/projects/home/mindtape/`

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
