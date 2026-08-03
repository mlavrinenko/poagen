# Resume state, end of 2026-08-04

Supersedes `session-resume-260803d.md`, which described a mid-session pause and
is now history, and `session-plan-260803c.md` for scheduling. That plan's
measurements and rulings still hold. Read this one first.

## Where the tree is

`main`, working tree clean, `scripts/gated-check` green and recorded,
`just check-examples` clean on all four trees, no worktrees left. Nothing is
pushed.

**Skip list: 78 to 11.** 1 DigitalOcean, 10 GitHub.

| after | skips |
|---|---|
| start | 78 |
| `merge-allof-members-into-one-model` | 60 |
| `a-union-request-body-takes-a-union-parameter` | 43 |
| the two parameter tasks | 20 |
| `a-union-response-selects-its-branch` + schemaless body | 11 |

**The remaining 11 are correct refusals, not a backlog.** Ten GitHub branch
sets genuinely mix an object with an array or scalar, and each now names that
cause rather than carrying stale "inline schema" text. The one DigitalOcean
entry is `uptime_create_check`, whose document requires a property no member
declares — the vendor's defect, refused by name rather than emitted short a
required field. Do not force this number to zero.

Every merge was re-gated on the integrated head. No task flipped on a branch's
own green run.

## Twelve tasks closed

Generator: `merge-allof-members-into-one-model`,
`a-union-request-body-takes-a-union-parameter`,
`support-the-parameter-shapes-real-documents-use`,
`ref-path-parameter-to-a-non-scalar-component-is-ungated`,
`a-union-response-selects-its-branch`,
`a-media-type-with-no-schema-takes-a-raw-body`,
`binary-format-advisory-fires-on-a-format-that-now-drives-behaviour`.

Truth and tooling: `record-the-union-pin-as-a-second-opt-out`,
`record-the-per-tree-duplication-ceilings`,
`gate-freshness-misses-the-files-linecop-lints`,
`agent-guide-is-nine-lines-from-its-own-cap`,
`the-freshness-manifest-enumerates-root-docs-and-drifts`.

## Read this before trusting any task text

Three tasks carried claims that were false on the tree, and each would have
shipped silently wrong output if believed.

- `a-union-response-selects-its-branch` non-goal said "Reading
  `discriminator.mapping`. No branch here declares one." **False.** Three of the
  eight declare an explicit mapping whose wire values are not the branch class
  names. Trusting it would have hydrated every one into the wrong class at
  exit 0.
- `ref-path-parameter-to-a-non-scalar-component-is-ungated` was **entirely
  unimplemented** in an interrupted worktree whose skip count looked like
  success. `supportsPath()` still carried the exact unconditional `Reference`
  short-circuit the task names as the bug.
- `support-the-parameter-shapes-real-documents-use` had two criteria with
  nothing behind them: no code in the repo read `style` or `explode` at all.

The general rule, now proven three times: a skip count is not evidence a
criterion was implemented, and a green gate cannot tell you a task's work is
missing. Audit bullet by bullet.

Also: a fixture that passes can hide a bug the real corpus finds. The union
response's structural layer was keyed by raw kebab-case component identity
instead of PHP class name; the self-contained fixture passed because its branch
names happened to equal their class names, and only the GitHub tree crashed.

## Two defects this session created and closed

Both the same shape — a fix meeting its criterion in letter while leaving the
drift it was written against.

- The freshness manifest enumerated seven root Markdown files by name. It
  drifted the same afternoon, to `AGENT_HAZARDS.md`. Replaced by a
  `./<pattern>` include form; `./*.md` rather than an eighth name.
- A bare sigil in a task artifact broke the gate repo-wide. It reached `main`
  because a head was gated and a status flip was committed on top. Backtick
  every sigil; gate after the last commit, not after the merge.

That second exposed a real hole, filed and unfixed:
`a-malformed-task-artifact-records-as-fresh`. `truth/tasks` is excluded from
the freshness hash for a sound reason its comment gives, but `speconaut check`
reads that directory and can fail on it.

## `mt` works again, with one sharp edge

Fixed mid-session. Two things to know:

- Transitions are enforced `accepted` → `wip` → `done`. Tasks flipped by hand
  while `mt` was broken went straight to `done`; artifacts validate, so this
  was not rewritten.
- **Short ids are unstable.** `5t` was the union-response task and seconds later
  `5t` was the media-type task. A command carrying a stale id was refused only
  because the task it landed on happened to be `accepted` rather than `wip` —
  had it been `wip`, it would have flipped the wrong task and looked like
  success. Re-read the id immediately before every flip and check the name `mt`
  prints back. Better: resolve by slug or path.
- `mt add` takes `--set key=value` and `--set 'tags[]=x'`; an apostrophe in the
  title makes it print usage and do nothing.

## Naming, ruled 2026-08-04

`paogen` is a typo. The vendor is `poagen`, the initialism of PHP OpenAPI
Generator, and the tool follows it — binary, repository, namespace segment, all
consumed prose. `truth/tasks/` deliberately keeps the old spelling, because a
task artifact records what was decided in the words used at the time.
Completion check is mechanical: `rg paogen` returns matches only under
`truth/tasks/`, with the changelog entry excluded.

Webhooks are skippable: the default stays a refusal, `$skip` gains a webhook
key spelling. Skippable is not ignored-by-default.

## Next session

1. `typed-error-responses` and `name-inline-schemas-by-operation-and-status`.
   One change in two tasks; both rewrite every generated method, so they land
   together now that the skip list has settled. Difficulty 8, not Sonnet work.
2. The release track, in the owner's order: rename, runtime to Packagist,
   generator, kilbil extraction, v0.1 criteria. The rename is mechanical now
   that both strings are settled.

Filed and unstarted, small:
`write-the-lessons-this-session-paid-for-into-the-guide` (four lessons, plus
the `mt` id churn above), `a-malformed-task-artifact-records-as-fresh`,
`a-referenced-response-component-is-invisible-to-the-schema-walk`.

## Standing hazards

`session-resume-260803b.md` still applies, with these corrections: writing a
note no longer invalidates a pass; the parser-accessor traps now live in
`AGENT_HAZARDS.md`; and `composer dump-autoload` after a merge is not
optional — a merge adding a generated fixture tree to the autoload map failed
fourteen tests on a class that was on disk the whole time. That fired again
this session, exactly as written.
