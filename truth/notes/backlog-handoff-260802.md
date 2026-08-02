# Backlog handoff, 2026-08-02

> Superseded in three places by `session-resume-260803.md`, which also carries
> the live state of an interrupted wave. Read that first. In short: the union
> work comes before composition, because composition declares a real
> `depends-on` against it; session 1 wave 2 below was never file-disjoint and
> was run in sequence; and `ResponseType.php` is contended by the envelope
> rather than reserved to it.

Written at the end of the session that unblocked the backlog. Its job is to let
three orchestrating sessions close the whole thing without re-deriving any of
the rulings behind it.

Read this with `mt ls`. Every claim here about a task's content lives in the
task file; this note carries only ordering, boundaries and the rules that are
not written anywhere else.

## What the owner ruled, in one place

Nine rulings, all landed in their tasks on 2026-08-02. Repeated here because a
subagent will not read fourteen task files.

1. A declared shape becomes a typed object. Never `mixed`, never an array
   standing in for an object. Typed lists and typed string-keyed maps are
   collections and stay arrays. A vendor's silence — no type, no properties, no
   items — may be reported as unconstrained, and that is the only exception.
   Now a goal: `goals/declared-shapes-become-types.goal.typ`.
2. Configuration cannot quietly be wrong. Every profile entry is a claim about
   the document, checked against it, and refused when false. Now a goal:
   `goals/guidance-cannot-mislead.goal.typ`.
3. An operation returns an envelope: status, hydrated body typed per the
   declared response, and the response headers as a string map. No PSR-7 object
   on it — that can be added later without breaking anything. 2xx is not
   special. A response the document did not describe raises.
4. Every security scheme that reduces to a credential gets wired, oauth2
   included. paogen sends tokens; it never acquires them. Flow metadata and
   scopes are emitted so a consumer can wire their own library.
5. An undiscriminated union emits a real PHP union and selects its branch from
   the payload. Refuse when two branches are genuinely indistinguishable.
6. Inline schemas are named `{OperationId}{StatusCode}Content`. Structural
   identity never merges anything on its own; only a profile entry does, and
   paogen verifies the shapes really match.
7. `additionalProperties: true` carries the extras in a runtime bag object. An
   omitted keyword is not `true` and changes nothing.
8. Nested XML containers get implemented. XML responses and multipart stay
   refused, because no vendored document uses them — revisit only if one does.
9. Truth-tree portability is not a value this project pays for. Artifacts may
   name files.

Publishing: the runtime goes to Packagist, then the kilbil client is extracted
to its own public repository. paogen itself is not published until its
capability is proven.

## Scope: what "the backlog is closed" means

All four examples generate with no expected-failure marker, no skip entry that
names a construct paogen could support, and committed generated trees for all
four. The hundred skip entries on the two large examples are covered by filed
tasks — they are not acceptable debt.

## The orchestrator's own rules

These caused real damage in earlier sessions. They are not optional.

- The orchestrator writes every artifact under `truth/`. Agents write code,
  tests and their own commit; they report findings in their final message and
  touch nothing under `truth/`. This removes the `truth/main.typ` collision that
  happens whenever two agents each add a decision, and it keeps the tree in one
  voice. Verified safe: the spec-first pre-commit hook is not installed here,
  `speconaut check truth/` does not demand a spec per source change, and the
  untraced-source ratchet is not wired, so an agent editing only `src/` stays
  green.
- Agents run every gate in the foreground and read its exit status before
  ending the turn. No `run_in_background`, no `&`, no Monitor — a pending
  background job ends the agent's turn and marks it complete on unfinished work.
  If the harness auto-backgrounds a long build anyway, the agent waits for the
  completion notification and reads the real status.
- Agents do not spawn agents.
- Every worktree agent asserts its base before doing anything:
  `git merge-base --is-ancestor <base> HEAD`, and that HEAD descends from it.
  On mismatch, `git reset --hard <base>` and re-verify. Worktree agents have
  been created from the wrong base and shipped passing-but-wrong diffs.
- Do not rely on the `isolation: "worktree"` parameter. Tell the agent to run
  `git worktree add <path> -b <slug> <base>`, `cd` in, `direnv allow`, then
  assert.
- Re-run the full gate on the merged HEAD after integrating parallel branches.
  A branch green in isolation can break the integrated tree.
- Commits carry `Refs: <task-slug>`; see CONTRIBUTING.md. `scripts/gated-check`
  runs `just check` and records the pass that `mt flip done` asserts.

## Sequencing constraints

Files that more than one task touches, so the waves have to respect them:

- `src/Generator/Emit/SchemaType.php` — the composition work and the widened-shape
  work both change how a type is read. Sequence, never parallel.
- `src/Generator/Emit/TypeResolver.php` — the same, plus the parameter work.
- `src/Generator/Profile.php` — six tasks add a key. Parallel is possible only
  because they add distinct keys; expect a merge conflict in the constructor and
  in `with()` every time, and resolve it orchestrator-side.
- `runtime/src/Contract/TransportInterface.php` and `ResponseType.php` — the
  envelope owns these. Nothing else may touch them in the same wave.
- The four `examples/*/paogen.php` profiles and their generated trees —
  every gap task removes skip entries from them. One task per example per wave.

## Session 1 — the parser, and type honesty

The parser swap goes first because every emitter change made after it is one
that does not have to be redone, and because it is contained.

Wave 1, alone: swap the OpenAPI parser. Nothing else runs — it moves
`composer.json`, `composer.lock`, deletes the patch, and every other task
rebases onto it.

Wave 2, parallel, disjoint files:
- close the three sites that widen a declared shape
- three more sites read only the 3.0 nullable flag
- path parameters run through no shape gate at all
- purge stale ADR numbers (docs only, no gate risk)

Wave 3, sequential on the type reader:
- resolve composition schemas in bodies and responses (68 operations)
- support the parameter shapes real documents use (23 operations)

Wave 4, parallel:
- synthesise a model for an inline array-item response
- represent non-JSON request and response bodies
- additional properties become a typed bag

Session 1 exit: the type reader is honest, and roughly 95 of the 100 skip
entries are gone.

## Session 2 — the envelope, security and the union

Wave 1, alone: the status-and-body envelope. It changes every generated
method's return type and both runtime contracts, so nothing runs beside it.

Wave 2, parallel:
- name inline schemas by operation and status (depends on the envelope, which
  is what makes an operation have two response models)
- wire every security scheme that reduces to a credential
- sub-client constructors take every scheme in the document
- emit the document's declared servers

Wave 3, alone: hydrate an undiscriminated union into a real PHP union type.
Three layers, and the hardest single task in the backlog.

Wave 4:
- a skipped component leaves dangling references behind it
- kilbil xml nesting
- scope a format binding to a property

Session 2 exit: the emitted client surface is final.

## Session 3 — the examples, the process, the release

Wave 1: clear the expected-failure markers on DigitalOcean and GitHub; commit
generated trees for both.

Wave 2, parallel, all docs or process:
- record that a failure inside a 200 body stays the consumer's business
- stop enforcing truth-tree portability
- make the domain model what the specs actually talk about
- turn the speconaut session workflow back on
- keep speconaut's embedded mindtape in step (upstream, in speconaut's repo)

Wave 3, sequential: close the v0.1 release criteria, publish the runtime to
Packagist, extract the kilbil client.

## Where a session should stop and ask

- Any ruling above turning out to be wrong against the code. Do not reinterpret
  one to make a task fit.
- A task whose acceptance criteria cannot be met without changing an accepted
  decision that is not already named in the task.
- The union work landing more than two unions in its refusal layer. The design
  assumes two; more means the discriminating-field rule is weaker than measured
  and the owner should hear it before profile entries are written for them.

## Measurements this session made, so nobody repeats them

- kilbil carries 87 multi-member `type` declarations; it is a 3.1 document by
  content. `redocly lint` reads it as 3.1 and reports the union types back.
- kilbil declares exactly 200 and 403 on all 36 operations, one shared 403
  schema, no `default`, no wildcards, all `application/json`.
- Security schemes: kilbil one apiKey in query; petstore one oauth2 implicit
  plus a requirement naming an undeclared `api_key`; DigitalOcean two http
  bearer; GitHub declares none at all.
- The 100 skip entries are seven gap families; the largest is 68 composition
  and typeless-but-propertied schemas, not the "inline schema" its message
  names.
- Of ~45 union branch schemas, exactly one declares `additionalProperties:
  false`.
- kilbil emits 511 model properties with zero native `mixed`; three `mixed`
  phpdocs, all honest. petstore the same. Zero suppressions in either tree.
- GitHub declares 240 response-header blocks, almost all `Link`. paogen reads
  none of them.
- No vendored document uses multipart. Two use `application/octet-stream`.
