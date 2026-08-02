#import "@local/mindtape:0.2.0": *

#show: task.with(
  title: "Decide runtime/src's place in spec-derived coverage: all 26 files are untraced",
  tags: ("speconaut", "traceability", "runtime"),
  priority: 4,
  difficulty: 3,
  status: wip(2026, 8, 2)[milestone: trust the instruments, then use them],
)

== Summary

Filed from measuring `restore-coverage-derived-traceability`. With
`speconaut audit-traces --adapter php-phpunit` actually running (blocked
until `audit-traces-ignores-the-configured-namespace` lands in speconaut;
measured locally against a workaround patch for this task), every one of
`runtime/src/`'s 26 files shows zero coverage across all 96 checked
scenarios — not a handful, all of them:

```
$ comm -23 <(find runtime/src -name '*.php' | sort) <(covered ∪ plumbing)
runtime/src/Attribute/Discriminator.php
runtime/src/Attribute/Format.php
runtime/src/Attribute/WireName.php
runtime/src/Contract/*.php  (11 files)
runtime/src/Http/*.php      (4 files)
runtime/src/Marshal/*.php   (6 files)
runtime/src/ScalarBinding.php
```

This is not a testing gap — `tests/Unit/Runtime/*` and
`tests/Integration/RuntimeSubstitutionTest.php` exercise this code
thoroughly. It is a structural fact: `truth/specs/`'s four features (Model
Generator, Operation Generator, paogen CLI, Profile) describe the
*generator's* behaviour — what PHP it emits — not the *runtime library's*
own behaviour, which paogen ships as a separate installable package (see
`runtime-ships-as-a-separate-package`). `speconaut audit-traces` only
instruments the manifest-listed `tests/generated/*Test.php` files; it
structurally cannot see coverage from `tests/Unit/` or `tests/Integration/`.

The spot-check against the 54 deleted hand-authored `traces:` (commits
`8badb4b`, `f4a8b83`) confirms the same boundary from the other direction:
8 of the 54 named a `runtime/src` file (e.g. "A discriminated `oneOf`
hydrates to the branch named by the wire tag via `#[Discriminator]`" named
`src/Runtime/Attribute/Discriminator.php`). None of those 8 are confirmed by
today's coverage, because the hand-authored claim conflated "the generator
emits code that references this runtime class" with "this scenario's own
test execution runs this runtime class's code" — the scenario tests the
former, PHPUnit line coverage measures the latter, and they are different
files entirely for anything that only exists in the emitted `Generated/`
tree, not in the generator's own process.

== Acceptance criteria

- One of, decided and recorded (a `truth/decisions/` artifact if the choice
  is non-obvious):
  + Drop `runtime/src` from `[check].source-roots` in `.speconaut/config.toml`,
    since it is a different bounded context with its own test suite outside
    the BDD loop, and the untraced-source finding should not carry 26 files
    that will never be zero by design.
  + Write BDD scenarios for `runtime/src`'s own behaviour (marshal/hydrate
    round trips, transport dispatch) so it participates in coverage-derived
    traceability on its own terms, alongside its existing unit tests.
  + Leave it configured and accept the 26-file warning permanently, with a
    comment saying why it will never shrink.
- Whichever is chosen, `.speconaut/config.toml`'s `[check].source-roots`
  comment states the reasoning so a future reader does not have to re-derive
  it.

== Non-goals

- Writing the BDD scenarios themselves, if that option is chosen — this
  task decides the policy, a follow-up would implement it.
- Anything about the 3 `src/`-rooted files the same spot-check surfaced
  (`InvalidProfileException.php`, `NameNormaliser.php`, `SymbolKind.php`) —
  those are a different, unrelated cause (zero-statement files never
  registering under line coverage) and are filed separately as
  `zero-statement-files-never-register-as-covered`.

== Files

- `.speconaut/config.toml`
- `truth/decisions/` — if the choice needs recording

== Result

Dropped. `.speconaut/config.toml`'s `[check].source-roots` is now
`("src", "bin")`, and the comment above it records both the measurement and the
structural reason. All 26 of `runtime/src`'s files were untraced across every
one of 96 checked scenarios — not a partial gap, a complete one, because
`speconaut audit-traces` only instruments the manifest-listed generated-test
suite while `truth/specs/`'s four features describe the generator's own
behaviour and never the separately-packaged runtime library's. No scenario
inside this project's spec scope would ever move that number, so leaving the
root configured would have handed the untraced-source ratchet a permanent
26-file floor nobody intends to drive down — the failure
`untraced-source-is-a-ratcheted-warning` already rejected once.

`[audit-traces].source-roots` deliberately keeps `runtime/src`, and does not
match `[check]`'s. The two keys answer different questions: one asks which files
a scenario's coverage may be attributed to, the other asks which files it is a
finding to have no scenario for. Keep the data, drop the nag. That distinction
is now written into the config beside both keys, since an identical key name
across two tables is exactly what a later reader mistakes for a typo and
"fixes".

Recorded as `runtime-src-excluded-from-untraced-source-check.decision-260802`,
weighed against `runtime-ships-as-a-separate-package` and the two rejected
alternatives. `runtime/src`'s own coverage, through `tests/Unit/Runtime/` and
`tests/Integration/RuntimeSubstitutionTest.php`, is untouched — this changes
what the traceability check reports, not what is tested.
