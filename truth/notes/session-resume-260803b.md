# Resume state, end of 2026-08-03

Supersedes `session-resume-260803.md`, which described a pause mid-session and
is now history. Read this one. `backlog-handoff-260802.md` remains superseded
in the three places that note named.

## Where the tree is

`main` carries every branch this session produced. The three worktrees the
earlier note said not to prune are merged and gone; nothing is left uncommitted
anywhere.

The last gate run of the session is recorded in its commit. If you are picking
this up cold, run `direnv exec . scripts/gated-check` and
`direnv exec . just check-examples` before trusting anything below — that is
cheaper than reading, and this file is exactly the kind of artifact whose facts
outlive them.

One trap worth knowing before the first run: after any merge that touches
`composer.json`'s autoload map, run `composer dump-autoload`. Six tests failed
on the integrated tree with `Class ... does not exist` purely because a
checkout's generated autoloader was stale, and the class was on disk the whole
time.

## What closed, sixteen tasks

Parser swapped to `devizzent/cebe-php-openapi`, with five 2020-12 constructs
aborting by name. ADR numbers purged. Three widening sites closed behind one
`ObjectShape`. Three narrow `nullable` readings routed through
`SchemaType::nullableOf()`. Path parameters gated by a shared `ParameterShape`.
Declared servers emitted as constants. The additional-properties bag. Security
wiring and sub-client scoping. Non-JSON bodies and scalar-list returns. The
operation-skip model leak. The duplication tier, twice. And the union.

Eight of those sixteen did not exist at the start of the day. They were filed
from measurements taken during the work, which is why the three-session plan in
the handoff did not survive: the backlog grows as the code gets honest.

### The union, since everything downstream depends on it

All fifteen undiscriminated unions resolve. Eight by a discriminating field
computed from the branches with no guidance at all; three by a tag on the
enclosing object (`Profile::$unionTags`); two by the closed-shape predicate —
`empty-object` is the one branch in either large document declaring
`additionalProperties: false`, so it accepts `{}` and nothing else; two by a
pin (`Profile::$unionPins`).

A payload matching zero branches or two raises. There is no third outcome and
no tie-break.

Both `.expected-failure` markers are gone and all four examples generate
cleanly. Their trees are committed — 7,242 files, GitHub alone 5,953 files and
25MB. That was `commit-generated-trees-for-the-large-examples`, accepted before
anyone knew the number. The owner was told the number and did not object, but
nothing is pushed, so it is still cheap to reverse if the weight turns out to
matter. The alternative considered was a per-file hash manifest: byte-stability
preserved, repo small, at the cost that no human can read the emitted output or
see what changed in a diff.

## The tripwire fired and was a false alarm — read this before re-arming it

The handoff said to stop if more than two unions landed in the refusal layer.
Six did, under the rules as the dispatching prompt phrased them. The agent
stopped, correctly.

The narrowing was the prompt's, not the design's. The task describes layer one
as a general mechanism ("the profile can name a property on the parent object
whose value selects the branch"); the prompt quoted its two examples as if they
were its scope. The closed-shape predicate is likewise the task's own stated
argument, in its own words. With both read as written, layer three holds at
two — `database_config.config` and `logsink_update.config` — which is what the
design assumed.

The lesson is not about unions. A prompt that quotes a task's examples as its
scope makes the task look weaker than it is, and the agent has no way to tell
the difference. Quote the rule, not the illustration.

## Four errors in the task's own union classification, now corrected

Measured against both documents rather than taken from the task:

- `commit.author` / `commit.committer` — the task said "decidable outright".
  False under its own rule: `empty-object` requires nothing and declares
  nothing, so it has no discriminating field. Only the closed-shape predicate
  decides them.
- `projects-v2-item-simple.content` — the task said each branch requires fields
  the others do not declare. False: every required field of
  `projects-v2-draft-issue` is declared by `issue`. Needs a parent tag.
- `repository-ruleset.conditions` — same claim, also false. Neither branch has
  a discriminating field.
- `secret-scanning-location.details` — the task said it needs a parent tag.
  False: the discriminating-field rule decides all thirteen branches unaided.

Also: 52 distinct branch schemas, not "roughly forty-five". The
"exactly one declares `additionalProperties: false`" claim held exactly.

## Two live hazards in the emitted surface

`repository-ruleset.conditions` maps a parent `source_type` that is **not
required** and whose enum carries three values against two branches. `Enterprise`
maps to nothing and raises at runtime. That is deliberate — the document permits
a shape paogen cannot type — and the generation-time report names it on every
run.

A pinned `database_config.config` hydrates a Postgres payload into
`MysqlAdvancedConfig` with no error, because those seven branches accept each
other's payloads. This is the first opt-out that can be wrong-looking-right;
a skip leaves nothing to be wrong with. It is why a pinned property is reported
on every run rather than only when the pin is written, and why `$unionPins` is
stale-checked exactly as `$skip` is.

## Decisions owed

Two were written this session after I closed their tasks on green code alone —
`every-credential-scheme-is-wired-not-refused` and
`a-binary-body-is-a-psr-7-stream`. Guard that pattern: a green gate is not a met
criterion, and the flip predicate cannot tell the difference.

Still owed:

- The union opt-out amendment. `skip-is-the-only-opt-out` needs a narrow
  amendment naming `$unionPins` as the second opt-out surface. The deciding
  argument, which came from the implementing agent and I accept: a pin is the
  only guidance key whose *absence* changes the exit status. `$tagChoice` is not
  analogous, because dropping it still generates.
- The duplication tier's per-tree ceilings. The reasoning is written in full in
  `scripts/jscpd-generated-baselines`, which is where a reader will look; the
  artifact should cite it rather than restate it.

## Next session

One or two agents at a time, not four. Three of this session's merge conflicts
came from two agents editing the same emitted output from different bases, and
resolving those cost more than the parallelism bought.

1. **Composition, alone, on Opus.** 68 of the ~78 remaining skips, now unblocked
   by the union it declared a dependency on. Its acceptance criteria hinge on a
   judgment call about merging `allOf` members, which is not Sonnet work.
2. **Parameter shapes.** 23 skips. Takes the skip list to roughly zero.
3. **The envelope, alone.** Changes every generated method's return type.
4. Inline naming, xml nesting, dangling refs — pairs, Sonnet.
5. Release: kilbil extraction, Packagist, v0.1 criteria.

## Standing hazards for every prompt

- linecop caps PHP at 250 and Markdown at 300 repo-wide. Three files went over
  on one merge purely by summing two branches' additions; neither was over
  alone. `AGENT.md` is ~9 lines from its own cap, filed as
  `agent-guide-is-nine-lines-from-its-own-cap`.
- Run `just lint-rector`, never bare `rector` — the shared `sys_get_temp_dir()`
  DI cache belongs to whichever worktree wrote it last.
- PHPStan `Deserialization failure` means a stale `build/cache/phpstan`. Delete
  it; it is per-checkout and gitignored.
- `parallel --halt now,fail=1` and `chronic` mask sibling failures in the lint
  fan-out. Run the specific recipe directly to read one. An agent found two real
  errors the aggregate had hidden this way.
- `python3` is not on PATH. Use `php`, and echo a confirmation from inside any
  throwaway script — a silent failure read as success for one agent today.
- Never `git checkout --` to park uncommitted work; `git stash push -u`.
- Check `composer.lock` for your branch name before committing: the runtime is a
  path-repo sibling and composer writes `"version": "dev-<branch>"`.
- When a change makes a construct representable, grep `truth/specs/` for that
  construct first. A scenario using it as its example of refusal becomes false,
  and fixing it forces a `speconaut generate-tests` and `lock` cycle — well
  outside any file list. This bit twice today.
- Figures quoted in a prompt deserve the same suspicion as figures in a doc. An
  agent was handed three measurements from another agent's report and none
  reproduced on the stated base.
