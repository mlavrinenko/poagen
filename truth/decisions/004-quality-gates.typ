#import "@local/speconaut:0.1.0": adr, accepted

#show: adr.with(
  number: 4,
  title: "Quality gates: PHPStan max + bleeding-edge + linecop on library code",
  status: accepted,
  date: datetime(year: 2026, month: 4, day: 18),
)

== Context

paogen has two distinct PHP audiences: the *library* itself (lives in
`src/`) and the *generated output* it produces. They have different
pathologies. Library code can grow into a big-ball-of-mud; generated code
doesn't, but it must withstand the user's own static analyser.

== Decision

=== Library code (`src/`)

- `phpstan analyse` at `level: max` with `phpstan-strict-rules` and
  `phpstan-deprecation-rules` enabled. Bleeding-edge config also enabled.
- `php-cs-fixer` on PER-CS 2.0 + PHP 8.4 rules.
- Rector dry-run gate.
- *Linecop* (#link("https://github.com/mlavrinenko/linecop")) limits PHP
  files in `src/` to *250 lines* (code + comments). Tests/fixtures
  excluded.

=== Generated code (`tests/fixtures/generated/**`)

- Must independently pass `phpstan analyse --level=max` *as the consumer
  would run it* (no library-internal baselines).
- Linecop *exempt* — generated files can be long.
- php-cs-fixer applied so the output matches what a careful PHP author
  would write.

=== Why bleeding-edge

paogen is pre-alpha; we want to find PHPStan tightenings as they ship, not
bulk-fix them at v1. Cost: occasional breakage on a PHPStan minor — that's
acceptable for an early-stage project.

=== Why a 250-line linecop limit

Generator emitter classes are the longest things we'll write. 250 lines is
generous for a single-purpose emitter and tight enough to force the
"extract another emitter" decision rather than letting one class swallow
the world. Tunable by editing `.linecop.yaml`.

== Consequences

- `just check` runs both library checks and generated-code checks.
- CI fails if either set drifts. PR diff for a generator change must
  include the regenerated fixtures.
- We *do not* set a separate phpstan baseline for generated code —
  generated code that fails PHPStan max is a generator bug.
