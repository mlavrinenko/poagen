# Resume state, end of the fourth 2026-08-03 session

Supersedes `session-plan-260803c.md` for scheduling only. Everything that note
says about measurement, the rulings and the standing hazards still holds, and
`session-resume-260803b.md` still holds for the union. Read this one first for
where the tree is.

## Where the tree is

`main` at `b7ef08a3`, working tree clean, `scripts/gated-check` green and
recorded, `just check-examples` clean on all four trees. Nothing is pushed.

Skip list: **78 to 43**. 8 DigitalOcean, 35 GitHub.

| point | skips |
|---|---|
| session start | 78 |
| after `merge-allof-members-into-one-model` | 60 |
| after `a-union-request-body-takes-a-union-parameter` | 43 |

Every merge was re-gated on the integrated head before any task flipped. No
task was flipped on a branch's own green run.

## One worktree is live and its state is unknown

    /home/tank/projects/home/paogen-wt/parameter-shapes   branch parameter-shapes

An agent was running `support-the-parameter-shapes-real-documents-use` and
`ref-path-parameter-to-a-non-scalar-component-is-ungated` in it when the
session stopped. The branch was still at `b7ef08a3` at that moment, so it had
committed nothing yet.

**Do not trust it.** Before anything: check whether the branch advanced, whether
the worktree has uncommitted changes, and whether whatever is there gates. If
it committed nothing, delete it and re-dispatch from scratch — that is cheaper
than auditing a half-finished diff. Both tasks are `accepted` and unstarted as
far as `main` is concerned.

## Seven tasks closed

`merge-allof-members-into-one-model` — recursive allOf merge into one
synthesised model. Closed both halves of one bug: eighteen DigitalOcean
refusals and nine silent widenings. The four `firewalls` sites emit a native
PHP union across synthesised branch models, so the `anyOf` constraint lives in
the type. Six named components got a bonus fix — a `required` property beside
`allOf` that the old one-level flatten had silently demoted to optional.
`uptime_create_check` gained a skip entry: it requires a property no member
declares, which is the vendor's defect, refused by name rather than emitted
short a required field.

`a-union-request-body-takes-a-union-parameter` — seventeen entries removed. Ten
GitHub refusals were rewritten in place rather than removed: their branch sets
genuinely mix an object with an array or scalar, so they stay refusals but now
name the real cause instead of stale "inline schema" text. Reused the allOf
task's `KIND_JSON_UNION`, parameter emitter and runtime marshaller unchanged.

`record-the-union-pin-as-a-second-opt-out` and
`record-the-per-tree-duplication-ceilings` — the two owed decisions.

`gate-freshness-misses-the-files-linecop-lints` — input set derived from the
recipes. `truth/notes` and `truth/reviews` are now tracked by name only, so
writing a session note no longer invalidates a recorded pass. That tax is gone.

`agent-guide-is-nine-lines-from-its-own-cap` — split by audience.
`AGENT.md` 219 lines with 81 spare, new `AGENT_HAZARDS.md` 86 with 214.
Nothing deleted.

`the-freshness-manifest-enumerates-root-docs-and-drifts` — filed and fixed the
same day, below.

## Two defects this session created and then closed

Worth reading, because both are the same shape: a fix that satisfied its
criterion in letter while leaving the drift it was written against.

**The manifest enumerated seven root Markdown files by name.** Its own task said
to derive the set rather than maintain a list that drifts. The list drifted
within hours, to `AGENT_HAZARDS.md`, created by another task the same
afternoon. Fixed with a `./<pattern>` include form; `./*.md` replaced the seven
names rather than gaining an eighth. Proven by adding a root Markdown file and
watching `is-fresh` go stale with no manifest edit.

**A bare sigil in a task artifact broke the gate for the whole repo.** A
done-reason contained an unbackticked dollar form; Typst read it as opening
math mode. It reached `main` because the head was gated, then a status flip was
committed on top and the earlier pass was treated as covering it. Backtick
every sigil, and gate after the last commit, not after the merge.

That second one exposed a real hole, filed as
`a-malformed-task-artifact-records-as-fresh`: `truth/tasks` is excluded from the
freshness hash for a sound reason its comment gives, but `speconaut check`
reads that directory and can fail on it, so a malformed artifact records as
fresh. Not fixed.

## The owner's two answers, both recorded

**Webhooks are skippable.** The default stays a refusal; `$skip` gains a key
spelling for a webhook. The task now says explicitly that skippable is not
ignored-by-default, because the reason given for yes would also support
dropping them silently, which is the reading rejected twice the same day.

**The vendor is `poagen`**, because it is the initialism of PHP OpenAPI
Generator. That answer reaches further than the string it settled: if `poagen`
is what the initialism spells, `paogen` is the transposed one. So a second
one-word question is now recorded in
`rename-the-vendor-packages-and-namespaces-before-publishing` and it is
unanswered — does the binary, the repository and the prose follow the vendor,
or does the tool stay `paogen` deliberately? Get it before the rename runs;
Rector over the same symbols twice is the avoidable cost.

## Next session

Both remaining waves touch `src/Generator`, and every remaining task's Files
list does — including `binary-format-advisory-fires-on-a-format-that-now-drives-behaviour`,
which `session-plan-260803c.md` had running parallel to a generator task. It
names `src/Generator/Emit/FormatAdvisor.php` and `src/Generator/Bindings.php`.
There is no valid parallel partner left among these. Run them one at a time.

1. `support-the-parameter-shapes-real-documents-use` plus
   `ref-path-parameter-to-a-non-scalar-component-is-ungated`, one agent, for
   the reason in the second task's own criterion: it forbids a second resolver.
   Roughly 23 skips.
2. `a-union-response-selects-its-branch` plus
   `a-media-type-with-no-schema-takes-a-raw-body`, one agent. Nine skips.
3. `binary-format-advisory-fires-on-a-format-that-now-drives-behaviour`, alone.

That leaves the ten rewritten GitHub refusals, which are correct refusals and
not a defect. The floor is not zero and should not be forced to zero.

Still deliberately out: `typed-error-responses` and
`name-inline-schemas-by-operation-and-status`, one change in two tasks, both
rewriting every generated method. They land together after the skip list
settles. Difficulty 8, not Sonnet work. Then the release track, in the owner's
order: rename, runtime, generator, kilbil, v0.1 criteria.

Also unstarted, small, filed this session:
`write-the-lessons-this-session-paid-for-into-the-guide` — four lessons the
split made room for.

## `mt` is broken and it is not this repo

The `mt` on `PATH` rebuilds `~/projects/home/mindtape` on every call, and that
checkout has uncommitted `Cargo.toml` / `Cargo.lock` edits that do not compile
— two versions of `typst_world`, one via `typst_harvest`. Every subcommand
exits 101. Nothing about poagen is wrong when this happens.

Worked around all session: edit task artifacts by hand, validate with
`speconaut check truth/` (about one second, parses every artifact), and call
`scripts/gate-fresh is-fresh` directly, which is what the `[[on.flip]]`
predicate calls. The mindtape checkout was deliberately not touched; reverting
those two files is the likely fix and it is the owner's call.

## Standing hazards

Everything under that heading in `session-resume-260803b.md` still applies.
Two corrections from this session: writing a note no longer invalidates a pass,
and the three parser-accessor traps now live in `AGENT_HAZARDS.md`.
