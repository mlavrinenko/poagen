#import "@local/speconaut:0.1.0": *
#import "../domain/generation.context.typ": *

#show: decision.with(
  title: "Quality gates: PHPStan max + bleeding-edge + linecop on library code",
  status: accepted(2026, 4, 18),
  contexts: (generation-context,),
  goals: (link("../goals/strict-clean-output.goal.typ"),),
  standards: (link("../standards/analysis-runs-at-maximum-strictness.standard-260729.typ"),),
)

== Context

paogen has two distinct PHP audiences: #the(Generator) itself (lives in
`src/`) and #a(GeneratedFile) it produces. They have different
pathologies. Library code can grow into a big-ball-of-mud; generated code
doesn't, but it must withstand the user's own static analyser.

== Choice

=== Library code (`src/`)

- `phpstan analyse` at `level: max` with `phpstan-strict-rules` and
  `phpstan-deprecation-rules` enabled. Bleeding-edge config also enabled.
- `php-cs-fixer` on PER-CS 2.0 + PHP 8.4 rules.
- Rector dry-run gate.
- Linecop (#link("https://github.com/mlavrinenko/linecop")) limits PHP
  files in `src/` to 250 lines (code and comments). Tests and fixtures are
  excluded.

=== Generated code (`tests/fixtures/generated/**`)

- Must independently pass `phpstan analyse --level=max` as the consumer
  would run it (no library-internal baselines).
- Linecop exempt — #a(GeneratedFile) can be long.
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
- We do not set a separate phpstan baseline for generated code — #a(GeneratedFile)
  that fails PHPStan max is a generator bug.
- Test coverage is not a v0.1 gate. codecov was wired with no threshold,
  which is worse than no coverage report at all: it implied a bar that did
  not exist. The `codecov.yml` config and the `code-coverage` CI job were
  removed. Much of paogen's logic is exercised via generated fixtures
  under `tests/fixtures/generated/`, so a line-coverage number on `src/`
  alone would be both noisy and misleading. When the code surface
  stabilises, a new decision may re-introduce a coverage threshold
  alongside mutation testing (also deferred per `ROADMAP.md`).
