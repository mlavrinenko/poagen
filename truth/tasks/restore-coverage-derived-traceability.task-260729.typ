#import "@local/mindtape:0.2.0": *

#show: task.with(
  title: "Restore spec-to-source traceability through the coverage-derived path",
  tags: ("speconaut", "traceability", "regression"),
  priority: 5,
  difficulty: 5,
  status: wip(2026, 8, 2),
)

== Summary

paogen's specs used to carry hand-authored \`traces: (...)\` tuples naming the source files each feature and scenario exercised — 54 of them: 28 in the model generator spec, 15 in the operation generator, 7 in the CLI, 4 in the profile. The old \`.speconaut/config.toml\` fed them through a \`\[traces\] source-dirs\` key.

Current speconaut removed the parameter from the DSL entirely. \`feature()\` and \`scenario()\` no longer accept \`traces:\`, and nothing in \`lib/spec.typ\` mentions it. Traceability is coverage-derived now: the test adapter reports which source lines each scenario actually executed, and \`speconaut audit-traces\` compares that against what was declared. That is a strictly better mechanism — a declared trace is a claim, a coverage-derived one is a measurement.

The migration therefore had to delete all 54 rather than relocate them, because there is nowhere to put them. They are preserved in git at commit \`d879084\` if any turn out to be worth consulting.

The regression is that the replacement is not wired up. Coverage-derived traces need the PHPUnit adapter pipeline running, and that pipeline is broken — the Justfile still invokes the removed \`speconaut interop extract\` subcommand. So between the migration and this task, paogen has no spec-to-source traceability of either kind.

== Acceptance criteria

- The PHPUnit adapter pipeline runs: \`speconaut generate-tests --adapter phpunit\` produces stubs, the suite runs with coverage, and \`speconaut audit-traces\` compares reported coverage against declarations without erroring.
- Every scenario that exercises source code resolves to at least one traced file, or is explicitly accounted for as plumbing in the \`\[audit-traces\]\` config with a reason.
- A source file under a configured source root with no scenario covering it is reported. Whether that is an error or a warning is a decision this task makes and records.
- The result is wired into a Justfile recipe and, if it is stable enough, into \`just check\`.
- Spot-check against the deleted declarations at \`d879084\`: any file a human had declared that coverage does not confirm is investigated, since that gap is either a missing test or a stale claim, and both are worth knowing.

== Non-goals

- Reintroducing hand-authored traces. The DSL no longer supports them and the measurement is better than the claim.
- Fixing the Justfile's broken subcommand invocation, which \`rewire-speconaut-justfile-recipes\` owns. This task depends on that landing first.
- Raising test coverage. This measures what traceability exists; closing gaps it reveals is separate work.

== Files

- \`Justfile\`
- \`.speconaut/config.toml\`
- \`tests/generated/\`

== Result

Wired, and blocked upstream — those are separate facts and both are load-bearing.

`speconaut audit-traces --adapter php-phpunit` reaches manifest resolution and
reports 96 scenarios checked, then fails all 96 identically with `phpunit exited
with code 1`. The cause is in the dependency, not here: the `php-phpunit`
adapter's `AuditTracesHandler` hardcodes its PHPUnit `--filter` namespace to
`Speconaut\Generated`, and the RPC envelope carries no namespace field to
override it — the sibling of a gap `carry-the-consumer-namespace-through-the-rpc-envelope`
already closed for `generate-tests`. Confirmed by reproducing the collector's own
PHPUnit invocation by hand: the hardcoded filter against a real
`Mlavrinenko\Paogen\Tests\Generated` class reports `No tests executed!` and exits
1, while the same invocation with the real namespace passes and reports real
coverage. paogen cannot work around it, because the namespace never reaches the
RPC params at all. Filed upstream as
`audit-traces-ignores-the-configured-namespace`.

So `just audit-traces` is wired and deliberately not in `just check` — it cannot
pass until that fix lands, and a gate that cannot pass is not a gate. Measured at
about 27 seconds for 96 scenarios, fast enough to join once unblocked.

Measuring past the blocker still answered the task's open question. 29 of 114
files under the configured source roots trace to no scenario: 26 are the whole of
`runtime/src/`, which is outside the BDD loop by design and covered by
`tests/Unit/Runtime/` and `tests/Integration/` instead, and 3 are zero-statement
`src/` files that line coverage cannot register as hit however often they
execute. That is dozens rather than a handful, and 90% of it is an understood
scope boundary, so it is recorded as a ratcheted warning rather than an error —
gating every commit on a number nobody intends to drive to zero teaches people to
bypass the gate. See `untraced-source-is-a-ratcheted-warning.decision-260802.typ`.

Two stale claims in `.speconaut/config.toml` are corrected. Its comment asserted
`tests/generated/manifest.json` does not exist; it does. And `[audit-traces]`
carries its own `source-roots` key, independent of `[check]`'s, which was
silently defaulting to `["src"]` alone and dropping `runtime/src` and `bin` from
the walk — a second bug found only because the first was being fixed.

The spot-check against the deleted hand-authored traces found the task's own
citation stale: `d879084` only touched `.speconaut/config.toml` and some task
renames. The real deletions are `8badb4b` (Model Generator, 28) and `f4a8b83`
(CLI, Operation Generator and Profile, 26), which is the 54 the task counted once
split correctly. Of the 72 declared files that still exist, 11 are untraced
today: 8 under `runtime/src`, and the same 3 zero-statement files. The 8 are a
category mismatch rather than a missing test — the hand-authored trace claimed
the generator's emitted output references that runtime class, while coverage
measures whether the scenario's own execution runs it. Those are different
claims, and only one of them is measurable. That is the clearest argument yet for
why the declared traces were replaced by measured ones.

Follow-on work filed rather than fixed here, per this task's non-goals:
`decide-runtimes-place-in-spec-derived-coverage` and
`zero-statement-files-never-register-as-covered`.
