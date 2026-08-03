# Resume state, 2026-08-03

Written at a hard pause, mid-wave. Read this before
`backlog-handoff-260802.md`, which it corrects in three places.

`main` is at `f7a749c`, working tree clean, `just check` and
`just check-examples` both last exited 0 at `275e223` — the only commits since
are task-status changes under `truth/tasks`, which the freshness hash excludes
by design.

## Update: relaunched, and two questions answered

The three interrupted agents could not be resumed — they were stopped rather
than paused, so their transcripts are readable but not continuable. Fresh
agents were launched into the same three worktrees instead, each told to read
the inherited uncommitted diff and judge it on its merits rather than trust or
discard it wholesale. The table below still describes what each worktree held
at the moment of the pause.

The owner was asked three things on resume and answered two of them by
delegation: the security buckets and the octet-stream body type are mine to
decide, and PSR-7 is acceptable either way provided the reason is written down
and applied consistently. The third — whether a new golden fixture tree can be
added later — is yes, and
`generated-tier-duplication-ratchet-blocks-new-golden-trees` already requires
committing the tree that was dropped.

### Ruling: a binary body is a PSR-7 `StreamInterface`, both directions

Decided 2026-08-03 under that delegation. The decision artifact follows once
the implementation lands and its consequences can be stated as fact rather than
prediction; the reasoning is recorded here first so an interruption cannot lose
it.

- PHP has no `resource` type declaration. A resource-typed body cannot be
  written into a property or a return type at all — it would be `mixed` plus a
  docblock. `declared-shapes-become-types` forbids a declared shape becoming
  `mixed`, so `resource` does not lose on taste; it loses to a goal.
- `runtime/composer.json` already requires `psr/http-message: ^2.0`,
  `psr/http-client` and `psr/http-factory`. Nothing is added.
- A runtime-owned stream wrapper would duplicate a standard interface and buy
  no guarantee the interface does not already give.
- The owner's ruling that the envelope carries no PSR-7 object means the
  envelope does not expose the PSR-7 *response* as transport plumbing. A body
  typed `StreamInterface` because the document declared a binary stream is the
  declared shape of that body. Those are different claims and only the first is
  ruled out.

## Three agents were interrupted. Their work is on disk, uncommitted.

Do not run `git worktree prune`, do not remove these three worktrees, and do
not delete their branches. Each holds real uncommitted work at its base commit.

| Worktree | Branch | Base | Uncommitted | Task |
|---|---|---|---|---|
| `~/projects/home/paogen-wt/security-wiring` | `security-wiring` | `521390e` | 43 files | `report-unsupported-security-schemes` |
| `~/projects/home/paogen-wt/additional-properties-bag` | `additional-properties-bag` | `f64b6c4` | 13 files | `additional-properties-become-a-typed-bag` |
| `~/projects/home/paogen-wt/non-json-bodies` | `non-json-bodies` | `275e223` | 0 files | `represent-non-json-request-and-response-bodies`, then `a-response-of-scalars-has-no-return-shape` |

On resume, per worktree: `git -C <path> status`, read the diff, and decide.
The security and bag worktrees are far enough along to finish rather than
restart. `non-json-bodies` had done nothing but `composer install`; restarting
it costs nothing.

All three tasks are `wip` on the board. That is honest — work exists — but if
any is restarted from scratch, say so in its status note rather than letting
`wip` imply continuity that isn't there.

Each of the three needs the same rebase before it can merge: their bases are
`521390e`, `f64b6c4` and `275e223`, and `main` has moved past all of them.

## What landed this session

Seven tasks, each merged into `main` and re-gated on the integrated HEAD
rather than trusted from its branch.

1. `swap-openapi-parser-for-31-support` — `devizzent/cebe-php-openapi`, the
   PHP 8.4 patch and `composer-patches` wiring deleted. `const`,
   `prefixItems`, `unevaluatedProperties`, `contentMediaType` and `webhooks`
   abort by name with a schema pointer.
2. `purge-stale-adr-numbers-from-the-truth-tree` — 109 files; `rg 'ADR-'`
   returns only that task's own mapping table.
3. `close-the-three-sites-that-widen-a-declared-shape` — `ObjectShape` asks
   the object question once; `ReturnSpec` carries a map's value as a nested
   `ReturnSpec`; `UnconstrainedFieldAdvisor` reports where `mixed` survives
   because the vendor declared nothing.
4. `emit-declared-servers-so-the-base-address-comes-from-the-document`.
5. `three-more-sites-read-only-the-30-nullable-flag`.
6. `path-parameters-run-through-no-shape-gate-at-all` — one shared
   `ParameterShape` predicate, per-position subsets kept distinct.
7. `synthesise-a-model-for-inline-array-item-responses`, re-scoped — see
   below.

Skip counts are unchanged at 100. Every task that removes skip entries
(composition, parameter shapes, non-JSON, scalar lists) is either in flight or
still queued. This session bought correctness in the type reader, not skip-list
reduction; the reduction is the next session's.

## Three corrections to the handoff

**The union comes before composition.**
`resolve-composition-schemas-in-bodies-and-responses` declares
`depends-on(declare-an-undiscriminated-union-as-raw-data)` and the dependency
is real: 9 of its 68 skips are GitHub responses typed `unspecified`, which are
`oneOf`/`anyOf` payloads needing branch selection. The handoff put composition
in session 1 and the union in session 2, inverting it. The union depends on
nothing — it does not need the envelope.

**Session 1 wave 2 was never parallel.** The handoff calls it "parallel,
disjoint files" and the files overlap:
`close-the-three-sites-that-widen-a-declared-shape` and
`three-more-sites-read-only-the-30-nullable-flag` both write
`InlineObjectResolver.php`; `close-the-three-sites` and
`path-parameters-run-through-no-shape-gate-at-all` both write
`TypeResolver.php`. They were run in sequence instead.

**`ResponseType.php` is not reserved to the envelope the way the handoff
implies.** It is a body-shape descriptor carrying a kind; the envelope wraps a
status and headers around the body it describes, so a new kind is additive.
What is real is contention — two agents must not write it at once — not
dependency.

## Decisions I owe, once the interrupted agents report

- The four security buckets, and why `oauth2` is wired despite
  `operations-delegate-to-an-injected-transport` putting token acquisition in
  the transport. `report-unsupported-security-schemes` requires it.
- The `application/octet-stream` request-body type: PSR-7 stream or resource.
  `represent-non-json-request-and-response-bodies` requires it.

## One question for the owner, not for an agent

The owner ruled the envelope carries status, hydrated body and headers, with
no PSR-7 object on it. A binary response body typed as a PSR-7
`StreamInterface` puts a PSR-7 object in the envelope's body slot. The request
direction has no such tension. The non-JSON agent was told to argue it
explicitly rather than settle it quietly; if it concludes PSR-7 is the honest
answer for the response body, that goes to the owner before any decision
artifact is written.

## Findings filed this session, all from measurement rather than review

`skipped-operation-still-emits-its-payload-model`,
`webhooks-refuse-with-no-opt-out`,
`generated-tier-duplication-ratchet-blocks-new-golden-trees`,
`form-urlencoded-body-requires-the-literal-type-object-keyword`,
`gate-freshness-misses-the-files-linecop-lints`,
`a-response-of-scalars-has-no-return-shape`,
`ref-path-parameter-to-a-non-scalar-component-is-ungated`,
`pathitem-level-parameters-are-invisible-to-the-document-wide-scan`.

Two are worth knowing before planning:
`generated-tier-duplication-ratchet-blocks-new-golden-trees` means no new
golden fixture tree can be committed at all, so emitted shapes added from here
on get no generated-tier analysis until it is fixed. And
`clear-example-expected-failures` now records that both `.expected-failure`
markers overstate what is left — two of their claims were fixed before this
session began.

## A blast radius nobody maps: specs that use the refused construct as their example

Found by the non-JSON agent, and it is a scoping lesson rather than a defect.

`represent-non-json-request-and-response-bodies` makes `text/plain` and
`application/octet-stream` representable. Four scenarios in
`truth/specs/operation-generator.feature-260418.typ` — lines 88, 178, 269 and
281 — used exactly those two constructs as their worked examples of a
construct that is *not* representable. The rules those scenarios assert all
still hold; only their examples became false. Nothing in the task's `Files`
list, and nothing in the boundary the orchestrator drew, pointed at that spec.

It is worse than an ordinary doc-drift dependent, because the fix is not a
text edit: the scenario text compiles into `tests/generated/*Test.php`, so
changing it forces `speconaut generate-tests`, rehoming the renamed step
bodies, and `speconaut lock` — a blast radius well outside the file list.

The rule: when a task makes a construct representable, grep the specs for that
construct before drawing the boundary. A scenario that uses it as an example of
refusal is part of the change, and the substitute example must be something the
task's own non-goals keep refused, so the scenario keeps testing its rule. Here
that was `multipart/form-data`.

## The measurement rule, stated for the third time

Three plans in this backlog have now rested on an unmeasured claim about a
large input file, and all three were wrong:

- the skip messages naming the wrong gap (68 composition, not "inline
  schema"),
- the union classification coming out opposite under strict validation,
- and this session's: three GitHub operations filed as arrays of inline
  objects, which declare `items: {type: string}`.

Each cost an agent. Measure the claim before designing around it — a wrong
grep is indistinguishable from a true negative, and a skip message that is
literally true can still read as the wrong shape.

## Next wave, when the three in flight are integrated

1. The union, alone. It needs `Profile.php`, `TypeResolver.php`,
   `CompositionResolver.php`, `DiscriminatorEnforcer.php` and
   `runtime/src/Marshal/Hydrator.php` — every one of them held by an
   interrupted agent, which is why it never started.
   Tripwire, unchanged from the handoff: if more than two unions land in the
   refusal layer, stop and tell the owner before any profile entry is written.
2. Composition, alone, on top of it. 68 skips.
3. `support-the-parameter-shapes-real-documents-use`. 23 skips.
4. The envelope, alone.
