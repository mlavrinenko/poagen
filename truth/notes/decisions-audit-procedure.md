# Decisions audit procedure

**Status:** active procedure
**Date:** 2026-08-01
**Input:** `scripts/audit-decisions [<mt-filter>]` (`--help` for its contract)

## What this replaces

The `needs-review` gate tried to make one person read code behind every
closed task. It queued thirty-eight tasks against a single reviewer and
none left — see
`truth/decisions/review-gate-must-be-mechanical.decision-260801.typ`. What
worked instead, once, on 2026-08-01, was reading only the *decisions* a
batch of closed tasks had made in passing, ranked, in one sitting. This
procedure is that reading made repeatable. `scripts/audit-decisions`
gathers the brief; everything below is how a human or an agent turns that
brief into a report.

This is a reading task. Nothing here is mechanical, and nothing here
gates a flip — see the non-goals below.

## What counts as a finding

A finding is a DECISION, not a defect and not a diff. Look for:

- a choice between defensible alternatives made without an artifact
  recording why
- a convention adopted in passing that now binds future work, with no
  standard or decision saying so
- an artifact contradicting another — a spec claiming what a standard's
  own structural slot already says differently, a task's acceptance
  criterion claiming completeness a later task disproved, a step body
  asserting the opposite of the scenario it implements
- a threshold or exemption set by fiat, with no rationale recorded
  anywhere a future reader would find it
- a spec bent to match what the code does, rather than the code fixed
  or the change to the spec argued for

A task doing exactly what its Summary and Acceptance criteria said, with
every artifact it touched recording why, is not a finding. Most closed
tasks are not a finding. That is expected, not a shortfall in the audit.

## Rank by consequence, and say enough to rule on

Order findings by how expensive they are to leave standing, most
consequential first. Consequence, not recency and not which task happened
to surface it.

Every finding states three things, because that is what makes it possible
to rule on in one reading:

1. what was decided — quote or paraphrase tightly enough that the owner
   is ruling on the actual choice, not a summary of a summary
2. what the alternatives were — what else was defensible at the time,
   even if only in hindsight
3. who or what it binds — which future tasks, which standards, which
   generated surface, inherits this choice if it stands unchallenged

## Owner findings vs. implementer findings

Split the findings list in two, so a reader can stop after the first part:

- **Needs the owner** — the choice trades off something only the owner
  can weigh: scope, a public contract, a threshold with no objective
  floor, anything that changes what paogen promises a consumer.
- **An implementer may accept** — the choice is sound and narrow enough
  that reversing it later, if it turns out wrong, costs about what
  making it cost. State it anyway; do not silently ratify it by omission.

A finding that could plausibly sit in either bucket goes in the owner's.
Cheap to move down, expensive to have hidden.

## A task that settled nothing

If a task's brief shows no decision — the work matched its acceptance
criteria, every artifact it touched already explained itself, nothing
contradicts anything else — say so in one line and move on:

> `<slug>` — nothing to rule on.

Do not pad this into a paragraph to look thorough. A report where every
task gets equal space is a report nobody can skim, and an audit that
returns diffs — or their prose equivalent — has failed no matter how
thorough it is.

## Say what you could not check

`scripts/audit-decisions` gives you the task's own sections, its commits'
subjects and diffstats, and which `truth/` artifacts those commits
touched. It does not give you the generated tree, the runtime behaviour,
or anything a commit did not narrate. When a finding would need one of
those to confirm — "does this exemption still hold against the current
emitter" — say plainly that it is unverified from the brief alone, rather
than reporting a judgement call as a checked fact. A guess dressed as a
finding is worse than an admitted gap: the owner can act on a gap.

## What this does not review

Not code quality, not style, not test coverage. `just check` — lint,
PHPStan, rector, the coverage floor — already owns those, continuously,
on every change; folding them into this reading is what made the earlier
review gate unusable. If a brief surfaces something that is purely a
code-quality concern with no decision behind it, it does not belong in
the report at all, not even as a low-priority entry.

This audit also does not reinstate a status a task must pass through
before closing, and it does not gate anything. It runs after a task is
already `done`; a wrong decision it finds is filed as a new task per
`review-gate-must-be-mechanical`, not reopened against the old one, and
nothing here blocks a flip to `done`. `.mindtape/config.toml`'s
`[[on.flip]]` predicate is the only mechanical gate and stays that way.

## Output contract

Write the report to `truth/reviews/<yyyy-mm-dd>-decisions-audit.md`
(directory precedent: `truth/reviews/2026-04-18-pre-release-review.md` —
note it is markdown, not Typst; reviews are not `truth/` artifacts and do
not need a `#include` in `truth/main.typ`). Open with the filter that
produced the input and the task count it covered, so the run is
reproducible. Then:

1. Findings needing the owner, ranked by consequence.
2. Findings an implementer may accept, ranked by consequence.
3. One line per task that settled nothing.
4. What could not be checked from the brief alone, if anything was
   skipped for that reason.

A report with an empty section 1 or 2 says so explicitly — omitting a
section reads as "not reached," an empty one reads as "reached and
clean."

# Structural sweep for a retired call shape

**Status:** active procedure
**Date:** 2026-08-02
**Motivating incident:** `truth/tasks/two-more-pre-transport-claims.task-260731.typ`,
`truth/tasks/pre-transport-claims-survive-the-sweep.task-260801.typ`

## What this replaces

`operations-delegate-to-an-injected-transport` retired a set of call
shapes the operation-generator feature described by name — `self::hydrate`,
`$request->withHeader(...)`, `sendRequest`, a Client constructed straight
off a PSR-18 client. The first sweep, `two-more-pre-transport-claims`,
searched the specs for a hand-picked vocabulary: PSR-18, PSR-17,
hydration, baseUri / `$baseUri`, factories, credential, ClientInterface,
RequestFactory, StreamFactory, PSR-7, "constructor takes". It fixed two
stale passages and closed, satisfied that a search turning up nothing
else meant nothing else was wrong.

The same day, `pre-transport-claims-survive-the-sweep` found seven more.
None of `sendRequest`, `withHeader`, `$request` or `self::hydrate` — the
words the retired call shape was actually made of — was ever on the
first list. One of the seven was a step body whose own comment read
"No `if` in the emitted body" while the assertion above it checked for
exactly that `if`, backing a scenario whose derived method name still
ended `...OnlyWhenApiKeyIsNotNull`. A sweep that reads like it worked —
two hits fixed, zero warnings, gate green — is not evidence of
completeness; it only proves the words on the list are gone.

A hand-picked vocabulary can only find what the sweeper thought to
type. The fix is not a better list. It's not building the list from
memory at all.

## The method

Derive the call-shape vocabulary from the tree the refactor actually
changed, then diff it against every call-shape mention in the specs.
Four steps, run from the repo root.

**1. Vocabulary the tree actually emits.** For a schema-driven refactor
(anything under `Generated/`), the tree is the byte-stable emitted
output:

```bash
rg -o --no-filename '(->|::)[A-Za-z_][A-Za-z0-9_]*\(' \
   examples/*/generated/Generated tests/fixtures/generated/*/Generated -g '*.php' \
  | sed -E 's/^(->|::)//; s/\($//' | sort -u > /tmp/emitted-vocab.txt
```

This lists every method the generator actually calls — `send`,
`header`, `path`, `query`, `json`, `object`, `listOf`, and so on — the
verbs, not the type names and not the collaborators.

Caution: `rg`'s `-h` is `--help`, not grep's "no filename". `-oh`
silently prints ripgrep's usage text in place of matches and every
downstream step goes quiet without erroring. Use `-o --no-filename`.

**2. Vocabulary the specs mention.** Same extraction, run over the
feature files:

```bash
rg -o --no-filename '(->|::)[A-Za-z_][A-Za-z0-9_]*\(' truth/specs \
  | sed -E 's/^(->|::)//; s/\($//' | sort -u > /tmp/spec-vocab.txt
```

Narrow the second path to the one feature file under sweep when the
refactor is scoped to it; widen it to `truth/specs truth/standards`
when the refactor's rule prose lives in a standard too —
`caller-surface-is-injectable`'s `structural:` slot was one of the
seven.

**3. Diff.** Everything the specs name that the tree doesn't:

```bash
comm -23 /tmp/spec-vocab.txt /tmp/emitted-vocab.txt
```

Every line out is a candidate, not a verdict. The tree in step 1 only
covers schema-emitted output — a rule describing a hand-written runtime
collaborator (`Hydrator`, `Marshaller`) never appears there and always
surfaces as a candidate. That's expected, not a false alarm to
suppress on sight.

**4. Settle each candidate by hand.** Grep the literal spec phrase —
receiver and method together, not the bare word — across the whole
executable surface:

```bash
rg -n '<exact phrase from the spec>' src runtime tests examples
```

Read what receiver the executable surface actually uses. Zero hits
anywhere means the shape is gone: drift, same as the seven. A hit on a
different receiver than the one the spec names is drift too, even
though the bare method name survived. A hit on the exact receiver the
spec names is not drift — move on.

## Run against the current tree, 2026-08-02

Scoped to the file the transport refactor actually touched —
`operation-generator.feature-260418.typ`, the drift this procedure was
written for:

```bash
$ rg -o --no-filename '(->|::)[A-Za-z_][A-Za-z0-9_]*\(' truth/specs/operation-generator.feature-260418.typ \
    | sed -E 's/^(->|::)//; s/\($//' | sort -u | comm -23 - /tmp/emitted-vocab.txt
```

No output. Clean — the two prior tasks already closed this one out.

Run wide, over every feature file at once (`truth/specs`, step 2 above,
unscoped), the same diff surfaces a candidate the prior sweeps never
touched: `hydrate`. Three of the five `hydrate(` mentions in
`model-generator.feature-260418.typ` name the receiver
`ApiClient::hydrate(...)` (lines 104, 202, 211); the other two already
say `(new Hydrator())->hydrate(...)` (lines 147, 178). Step 4 —
`rg -n 'ApiClient::hydrate' src runtime tests examples` — returns zero
hits. Every executable path hydrates through a bare `Hydrator`
instance instead, and `ModelGeneratorSteps.php`'s own doc comment says
why: "Per ADR-010 this is a free function — the generated `ApiClient`
no longer carries a private `hydrate()` helper." The derived step
methods still encode the stale receiver in their names —
`whenClientCallApiClientHydratePetClassDataRunsAgainstAPayloadWhoseKindPetTypeIsWire`,
`thenApiclientHydrateContactClassEmailTeamExampleProducesModelContactWhoseEmailIsAnEmailInstanceWithValueTeamExample`.
This predates the transport refactor — ADR-010 retired
`ApiClient::hydrate()` in
`attribute-and-phpdoc-driven-serialization.decision-260420.typ` — and
is unrelated to it. It is recorded here, not fixed here: fixing spec
text is outside what this note does, same as it was outside what wrote
this section.

The same wide run also flags `getDocComment` and `marshal`. Both check
out under step 4: `getDocComment()` is real, called on a bare
`ReflectionMethod` exactly as phpdoc-referenced; `(new
Marshaller())->marshal(...)` appears verbatim at nine call sites.
Two of the three candidates from the wide run were noise — that's the
price of widening past the tree the refactor under sweep actually
touched, and step 4 exists to pay it.
