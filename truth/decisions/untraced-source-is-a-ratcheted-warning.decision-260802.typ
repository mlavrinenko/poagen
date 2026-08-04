#import "@local/speconaut:0.1.0": *
#import "../domain/generation.context.typ": *

#show: decision.with(
  title: "An untraced source file is a ratcheted warning, not a hard error",
  status: accepted(2026, 8, 2),
  contexts: (generation-context,),
  goals: (link("../goals/strict-clean-output.goal.typ"),),
  process-only: "governs poagen's own traceability-gate policy — what the untraced-source finding blocks a commit on — not what the generator produces or what a reimplementation must do",
)

== Context

`restore-coverage-derived-traceability` measured, for the first time, how
many files under `.speconaut/config.toml`'s `[check].source-roots =
["src", "runtime/src", "bin"]` are exercised by zero of the 96 checked
scenarios. The measurement needed a local, uncommitted workaround for an
upstream blocker (`audit-traces-ignores-the-configured-namespace`, filed in
speconaut's own tracker — `AuditTracesHandler` hardcodes the PHPUnit filter
namespace and never reads poagen's configured one, so every scenario fails
identically with "phpunit exited with code 1" until that lands) and is
reverted; the numbers below are real but were measured, not locked.

Of 114 files across the three source roots, 29 are untraced:

- *26 of 26* — every file under `runtime/src/`. Not a testing gap:
  `tests/Unit/Runtime/*` and `tests/Integration/RuntimeSubstitutionTest.php`
  exercise this code directly. `speconaut audit-traces` only instruments
  `tests/generated/*Test.php` (the manifest-listed, spec-derived suite), so
  it structurally cannot see coverage from poagen's own hand-written
  PHPUnit tests. `truth/specs/`'s four features describe the *generator's*
  behaviour, not the separately-installable runtime library's
  (`runtime-ships-as-a-separate-package`) — this is a scope boundary, not a
  bug, and is tracked on its own as
  `decide-runtimes-place-in-spec-derived-coverage`.
- *3 of 88* in `src/` — `Exception/InvalidProfileException.php`,
  `Generator/Naming/NameNormaliser.php`, `Generator/Naming/SymbolKind.php`.
  All three are zero-executable-statement files (an empty exception
  subclass, a bare interface, a caseless enum) that a still-running
  scenario almost certainly does exercise structurally, but line coverage
  has nothing of the file's own to mark as hit. Tracked separately as
  `zero-statement-files-never-register-as-covered`.
- *0 of 0* in `bin/` — the directory carries no `.php` file today.

Separately, comparing this run against the 54 hand-authored `traces:`
declarations deleted in `8badb4b` (Model Generator, 28) and `f4a8b83` (CLI,
Operation Generator, Profile, 26) — the task's own brief cited `d879084`
for this, which is stale; that commit touched only `.speconaut/config.toml`
and task renames, not any spec file — found that per-scenario coverage
*attribution* is architecturally coarse, not broken. Profile scenarios
(4 of them) trace 1-2 files each; Model Generator and Operation Generator
scenarios trace 50-60 files each, on average, because
`Generator::generate()` is a single monolithic pipeline that fans out
through most `Emit/*`, `Naming/*`, and `Enum/*` helper classes for *any*
schema input, however narrow the scenario's own assertion. If isolation
between per-scenario PHPUnit processes were actually leaking state,
Profile's numbers would be broad too — they are not, which is the evidence
this is real, honestly-measured coverage, just far less curated than a
human picking one to nine relevant files ever was. `speconaut lock` was not
run to capture this — doing so before the upstream fix lands would bake in
either nothing (every scenario failing) or, briefly, the coarse ~4400-trace
figure this decision describes but does not adopt. That choice — whether a
lockfile this coarse is worth having, and if so at what floor — belongs to
whoever picks up the upstream task and re-attempts `lock`, not to this
decision.

== Choice

An untraced source file, once `speconaut check`'s untraced-source finding
actually runs against a working adapter, is a *warning*, ratcheted only
downward (fewer untraced files over time, never more), not a hard error.

29 named files does not clear the bar for a hard error. The acceptance
criterion that prompted this decision put it plainly: "if it names a
handful, an error is defensible; if it names dozens, a warning that
ratchets is the honest choice." 29 is dozens, and 90% of them (26 of 29)
are a scope boundary this project has separately decided is fine to leave
open (runtime tested outside the BDD loop) rather than a real gap — an
error today would gate every commit on a number nobody intends to drive to
zero, which is the same failure mode `coverage-floor-in-the-gate` rejected
for an unread coverage recipe: a bar nobody is actually watching is worse
than no bar.

A ratchet still gives the finding teeth: the ceiling starts at 29 (or
whatever the number is once the upstream namespace fix lands and this can
actually run) and can only move down, the same shape as the duplication
threshold and the coverage floor already use elsewhere in this repo's
gate. Closing `zero-statement-files-never-register-as-covered` moves it by
3; closing `decide-runtimes-place-in-spec-derived-coverage` in either
direction (excluding `runtime/src` from the source-roots list, or writing
it specs of its own) moves it by up to 26.

== Consequences

- This is a policy decision with nothing to wire yet: the untraced-source
  finding cannot run for real until `audit-traces-ignores-the-configured-namespace`
  lands upstream. Whoever wires the ratchet (a `scripts/untraced-source-ceiling`
  in the shape of `scripts/coverage-floor`, or the equivalent) reads this
  decision for the starting number and the reasoning, rather than re-deriving
  either.
- The 26/3/0 breakdown is the baseline the ceiling starts from once wiring
  lands — not something this decision commits to a specific number today,
  since the exact count on the day wiring lands may differ from the 29
  measured here.
- Nothing here changes `[check].source-roots` itself; that is
  `decide-runtimes-place-in-spec-derived-coverage`'s call to make.
- The coarse per-scenario attribution this measurement surfaced is not
  addressed here. It is real, accurate coverage, not a defect, and closing
  it (decomposing the generator's pipeline, or accepting the coarse trace
  as good enough) is future work this decision does not scope.
