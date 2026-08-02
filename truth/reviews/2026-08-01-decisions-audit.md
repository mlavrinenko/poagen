# paogen — Decisions Audit (2026-08-01 closed set)

Procedure: `truth/notes/decisions-audit-procedure.md`. Input:
`scripts/audit-decisions`, run over every task whose `status.date` is
`2026-08-01` — 58 tasks.

`mt`'s filter grammar has no field for a status's transition date (only
`status priority difficulty kind title id due start reviewed file`), so the
set was derived once, client-side, and passed as an explicit filter:

```
mt ls @recent --format json \
  | jq -r '[.tasks[] | select(.status.date=="2026-08-01") | .file]
            | map("file == \"" + . + "\"") | join(" || ")'
scripts/audit-decisions "<the 58-clause filter above>"
```

Re-running the `jq` line against a fresh `mt ls @recent --format json`
reproduces the identical filter as long as no task's status changes since.

## Findings needing the owner

### 1. The reverted PHPStan-strictness relaxation was never recorded as a decision

`rewrite-agent-guide-for-mindtape` (commit `312cd5f`) quietly rewrote
`analysis-runs-at-maximum-strictness` from an unconditional zero-suppression
rule into a two-tier one permitting `ignoreErrors` in the generator's own
config wherever "provably blind." `revert-the-strictness-relaxation`
reverted the wording and paid the exemptions down; verified directly against
`phpstan.neon.dist`, which now carries exactly five `- identifier:` entries,
each under an inline comment naming its blind spot. That part landed clean.

Its own acceptance criteria required more: "A decision artifact records the
reversal — relaxation is opt-in, never opt-out — so the next agent reading
`rewrite-agent-guide-for-mindtape`'s commit message does not read the
relaxation as the settled answer." No such artifact exists.
`truth/decisions/quality-gates-at-maximum-strictness.decision-260418.typ` is
the only decision touching this ground, and it is dated 2026-04-18 — three
and a half months before the relaxation happened, let alone its reversal —
and says nothing about relaxation being opt-in only.

**Alternatives:** leave it as the standard's reverted prose alone (what
shipped); write the missing decision now; or rule the acceptance criterion
over-specified and let the standard's rule text stand as the record.

**Who it binds:** every future PHPStan finding in the generator tier. The
standard's own rule text has already drifted once inside this project's
lifetime; nothing on record says the next relaxation attempt is any less
welcome than this one was.

### 2. `[check.code-refs]` cannot see a bare implementation-file basename, and the scope question was left open

`standards-stop-naming-implementation-files` found that
`caller-surface-is-injectable` and `guidance-is-data-not-code` named five
real files by bare basename in their `structural:` slots
(`ClientConstructor.php`, `SubClientEmitter.php`, `Profile.php`,
`ProfileLoader.php`, `AttributeScanner.php`) — three days after
`narrow-the-code-ref-exemption` had reported the tree swept clean of exactly
this, because its check matches path-shaped references and a bare basename
carries no `src/` prefix. Commit `d385ab0` rewrote all five to describe
enforcement without naming a file, which fixes the five known instances.

The task's third acceptance criterion required the scope question answered
explicitly: is `[check.code-refs]` meant to catch bare basenames too (name a
follow-up to widen it), or is it deliberately scoped to path-shaped
references only (correct `narrow-the-code-ref-exemption`'s acceptance
criterion, which still reads as an unqualified absolute)? Neither happened —
no Result section, no commit, no follow-up task. Verified directly:
`.speconaut/config.toml`'s `[check.code-refs] allowlist` is still `("(",
"::")`, unchanged, and still only matches path-prefixed patterns.

**Alternatives:** widen the checker — paogen-side, or an upstream speconaut
ask on the model `process-only-decisions-may-name-a-file` used for its own
dependency; or accept the gap explicitly and correct
`narrow-the-code-ref-exemption`'s now-overstated criterion; or leave it as
found, undocumented.

**Who it binds:** every future `structural:` slot and every future decision
or spec. The mechanism meant to keep `truth/` portable across a
reimplementation has a known blind spot for exactly the reference an agent
reaches for by habit — a bare class name — and nothing currently catches a
recurrence.

## Findings an implementer may accept

### 3. The pre-transport sweep trusted a guessed keyword list over a structural check, twice

`two-more-pre-transport-claims` searched a hand-picked vocabulary (PSR-18,
PSR-17, hydration, baseUri, factories, credential, ClientInterface, …),
fixed two stale passages, and closed. One fix required a derived
step-method rename (`...PlacedAfterBaseUri` → `...PlacedAfterTransport`),
and its acceptance criteria required "the renamed step method keeps its
hand-written body; say in the report how that was verified rather than
assumed." Verified directly: none of that task's four commits touch
`tests/generated/` at all (`git diff --stat <commit>^1 <commit> --
tests/generated` is empty for all four) — the regeneration and body
carry-over never happened inside this task. It happened later, inside
`pre-transport-claims-survive-the-sweep`'s commit.

That same-day follow-up found seven more stale passages the first search's
vocabulary could not have found, because `sendRequest`, `withHeader`,
`$request` and `self::hydrate` were never on the list — one of the misses
was a step body asserting the literal negation of the scenario it
implemented ("No `if` in the emitted body" beside a method name still
ending `...OnlyWhenApiKeyIsNotNull"). Both tasks are transparent about this
in their own text; the drift is fully corrected in the tree today (checked:
`rg -n "sendRequest|withHeader|self::hydrate|PlacedAfterBaseUri" truth/specs/
tests/generated/` returns only a PSR-18 `ClientInterface::sendRequest`
implementation inside a test double, where the method name is required by
the interface, and one comment giving a hypothetical example — no live
claim about the retired call shape remains).

**Alternatives:** keep closing this class of task on a hand-picked keyword
list, refined only by what the previous pass's gaps happened to reveal
(what shipped, twice); or verify completeness structurally — grep the
emitted/fixture tree for the retired call-shape vocabulary and diff that
against every mention in `truth/specs/`, which is what actually closed the
second pass.

**Who it binds:** the next refactor that retires a call shape, a class, or
a constructor signature the specs describe by name. Low risk to defer —
nothing currently open depends on it — but worth a line in
`truth/notes/decisions-audit-procedure.md` or a standard the next such
sweep can point at, so the fix is structural rather than a sharper guess.

## Tasks that settled nothing new to rule on (54)

Generator-correctness fixes closing a live silent-degradation gap the
standards already forbade, no decision left open:
`abort-on-unrepresentable-constructs`, `default-deny-on-degradation`,
`inline-body-and-response-schemas`, `nullable-type-arrays`,
`query-apikey-security-scheme`, `report-unrecognised-formats`,
`operationid-word-splitting` (one real design call inside it — rejecting
vocabulary-derived name splitting, argued and cited against
`cheap-regeneration` and `real-world-schemas` — but recorded only in the
task body, not a `truth/decisions/` artifact of its own; low consequence,
noted rather than ranked).

Architecture decisions that landed with their own cited `truth/decisions/`
artifact stating the trade plainly: `collapse-operations-onto-a-runtime-
transport`, `emit-tagged-subclients-with-interfaces`,
`swappable-runtime-contracts`, `runtime-package-split`,
`xml-content-type-policy`, `xml-response-outcome` (correctly supersedes
`xml-content-type-policy`'s contradicting criterion, named explicitly),
`subclient-scenario-asserts-old-constructor`.

Example-tree scope and gate coverage, mechanical once the generator changes
above landed: `kilbil-loyalty-client-proof`, `bind-kilbil-numeric-formats`,
`examples-readme-counts-three`, `examples-check-themselves`,
`analyse-example-generated-trees`, `stale-trees-under-expected-failure`.

Gate and tooling mechanics, each with a measured number or a mechanical fix
written down: `flip-gate-asserts-the-real-check`,
`retire-the-human-review-gate` (the meta-decision this audit replaces — see
`review-gate-must-be-mechanical`), `require-a-task-trailer-on-every-commit`,
`commit-composer-lock`, `scope-the-php-tool-cache`,
`update-the-pinned-qa-tools`, `coverage-floor-in-the-gate`,
`adopt-jscpd-duplication-gate`, `jscpd-as-a-real-gate`,
`deduplicate-the-test-suite`, `import-global-functions-in-source`,
`import-generated-type-references`, `generated-files-declare-themselves`.

Truth-tree and speconaut-migration housekeeping restoring `speconaut check`
after the tool's schema moved on, no decision embedded:
`migrate-adrs-to-decision-artifacts`, `migrate-domain-to-context`,
`migrate-specs-to-feature-subextension`, `paogen-standards-library`,
`speconaut-config-rewrite`, `rewire-speconaut-justfile-recipes`,
`refresh-the-speconaut-lockfile`, `declare-paogen-runs-no-sessions`,
`adopt-the-unset-speconaut-config-surfaces`, `settle-refs-footer-policy`,
`rewrite-agent-guide-for-mindtape`, `recheck-the-agent-guide-against-
artifacts`.

Standards-coverage and process-only cleanup, each closing a gap the
standard itself named, with the ruling recorded where a reader would find
it: `give-the-uncovered-standards-an-obligation`,
`standards-need-testable-obligations` (its `nameNormaliser`-carve-out fix
verified directly: commit `f093ed3` states plainly that the correction does
not retroactively bless the callback `adopt-jscpd-duplication-gate`
proposed and rejected), `tag-scenarios-for-standards-coverage`,
`narrow-the-code-ref-exemption`, `process-only-decisions-and-file-names`
and its artifact `process-only-decisions-may-name-a-file` (checked in full:
names the upstream speconaut commit it depends on and states the ruling
lapses if that regresses), `audit-phpstan-generator-exemptions`
(re-verified all five surviving exemptions empirically, one at a time,
changed nothing), `reword-the-domain-context-split`,
`implement-the-outrun-step-bodies`.

## What this audit could not check

Read the task's own Summary / Acceptance criteria / Result text, commit
subjects, diffstats, and which `truth/` decisions, standards or specs each
commit touched — not full diffs of source or generated code. For the three
findings above, the underlying files (`phpstan.neon.dist`, the named
decision and standard files, `.speconaut/config.toml`, specific commits'
full diffs) were read directly to confirm the claim rather than trusted from
the brief alone. For the 54 tasks in the settled-nothing list, verification
stopped at the task's own text, its commits' subjects, and which `truth/`
artifacts they touched — a decision made only inside a diff, narrated in
neither the task body nor any commit subject, would not surface through
this method. That is a real gap in the brief, not a claim that none exists.

This audit did not run `just check`, regenerate any example tree, or verify
runtime behaviour — code quality, style and test coverage are out of scope
by design (see the procedure). Nothing here should be read as a claim that
the generator itself behaves as its decisions describe, only that the
decisions are (or, for the two owner findings, are not) recorded where a
future reader would find them.
