#import "@local/speconaut:0.1.0": *
#import "../domain/generation.context.typ": *

#show: decision.with(
  title: "The standalone check's staleness is caught inside the offline gate, not by a schedule or a rewrite",
  status: superseded(2026, 8, 8),
  contexts: (generation-context,),
  goals: (link("../goals/strict-clean-output.goal.typ"),),
  process-only: "governs poagen's own test-gate configuration (how a check outside `just check` stays trustworthy), not what the generator produces or what a reimplementation must do",
)

== Context

`keep-the-standalone-runtime-check-from-rotting-outside-the-gate.task-260805.typ`
records the measured failure: `scripts/verify-runtime-standalone` proves
runtime-package-split's central claim — a generated client installs and
runs on `poagen/client-runtime` alone — by hand-writing a consumer
(`run.php`) against the petstore example's generated API. That hand-written
code drifted out of step with the generated API twice without anyone
noticing. `security-wiring` gave `ApiClient` a credential per declared
scheme while `run.php` still constructed it with a transport alone;
`typed-error-responses` replaced `getPetById`'s `Pet` return with an
`Envelope` while `run.php` still read the model directly. Both were fixed
in the same commit, `85d9da67`, once someone finally ran the recipe by
hand. The recipe sits outside `just check` because it resolves
`nyholm/psr7` from the network, which the offline gate does not assume — a
real constraint the task's own non-goals forbid revisiting by folding the
recipe into `just check` as-is.

Confirmed before making any change: `just verify-runtime-standalone` on
this task's base commit (`e8420d2c`) passes —
`OK: generated client ran on poagen/client-runtime alone (generator
absent)` — so the drift the task describes was already fixed on this
branch's base; what was missing was a way to stop it recurring silently a
third time.

The task named three candidate answers and asked for one, with reasoning
for rejecting the other two:

+ Run the check on a schedule something enforces.
+ Stop hand-writing the consumer side.
+ Make the check's staleness detectable from inside the offline gate.

== Choice

=== Option 3: an offline test pins the shape `run.php` depends on

`tests/Integration/StandaloneHarnessTracksGeneratedApiTest.php` regenerated
the petstore example from the exact profile (`examples/petstore/poagen.php`)
`just check-examples` already treats as the source of truth, through
`Generator::plan()` — in-memory, no network, no disk write, the same
technique every other test under `tests/Integration/` already uses to pin
emitted shapes. It asserted the two facts `run.php`'s hand-written call site
depended on: `ApiClient`'s constructor took exactly the three positional
arguments `run.php` passed, in that order (`$transport`, `$apiKey`,
`$petstoreAuth`), and `getPetById` returned an `Envelope` whose `200` status
mapped to `Pet::class`. It ran as a normal PHPUnit test — `just test`,
`just test-coverage`, `just check`, and both `unit-tests` and `coverage` in
`.github/workflows/continuous-integration.yml` already executed
`tests/Integration/` — so it was not a new recipe or a new CI job, it was a
new assertion inside machinery every push already ran. The file itself no
longer exists — see `=== Superseded` below.

=== Why not option 1 (a schedule)

A scheduled run only shortens the interval between breakage and discovery;
it does not stop a broken commit from landing, and it does not run against
the commit that broke it — it runs against whatever `main` is when the
schedule fires, so the failure surfaces divorced from the change that
caused it, on a run nobody is watching interactively. The task's own
framing states the sharper problem directly: "a check that proves a
release-critical claim and is run by nobody proves nothing." A cron job is
still nobody, just on a timer. It was also not free to build inside this
task's file boundary: `.github/workflows/` runners have real network, so a
scheduled job would not need the network re-examination below at all,
which would leave that question exactly as unexamined as the task found
it.

=== Why not option 2 (stop hand-writing the consumer)

The task's own recommendation named this the one that "attacks the actual
cause," and that is correct in the abstract — `run.php` is a hand-written
consumer that must track a moving generated API, and the two historical
breaks are exactly that tracking failing. It was not chosen here for a
concrete reason, not a rejection of the diagnosis: this task's file
boundary is `scripts/verify-runtime-standalone`, the `Justfile` recipe
region, `.github/`, new files under `tests/Integration/`, and a decision
artifact — it does not include the generator (`src/`) or the example
(`examples/petstore/`). A `run.php` that is no longer hand-written would
have to be synthesised from the generated API's actual shape — enumerating
`ApiClient`'s constructor parameters and calling a real operation
generically — which is either a second, smaller code generator (a new
capability belonging in `src/`, outside this task's boundary) or a rewrite
that stops calling named methods with named fixtures (`pet()->getPetById(42)`
expecting a pet named `Rex`), which trades the concrete regression test
this check has always been for a structural-shape check with no behavioural
content — the non-goal "changing what the check proves" forbids exactly
that trade. At the time this decision was made, option 2 was believed to
need its own task, scoped to touch the generator or the example — see
`=== Superseded` below for how that assumption turned out to be wrong.

=== Option 3 composes with option 3 alone here, and that is enough

The task's hint that option 3 "is cheap and composes with either" held:
nothing about the offline test above forecloses a future option 1 or
option 2. It was not paired with either in this change because the task
asked for one option chosen, with reasoning for the other two, not for all
three landed at once.

=== Proof: the mechanism catches what a human forgetting to run the recipe would miss

Reproduced locally, not committed: added a third security scheme
(`admin_key`, an `apiKey` header scheme) to
`examples/petstore/schemas/petstore-3.0.yaml`'s `getPetById` operation,
without touching `scripts/verify-runtime-standalone` or `run.php` — the
same shape of change `security-wiring` made. Result:

- `tests/Integration/StandaloneHarnessTracksGeneratedApiTest.php` went red
  on `testApiClientTakesExactlyTheThreePositionalArgumentsTheHarnessPasses`:
  the regenerated `ApiClient` constructor gained a fourth parameter
  (`$adminKey`, sorted ahead of `$apiKey`), so the pinned three-argument
  substring no longer matched.
- `just verify-runtime-standalone`, run against the same drifted schema,
  still printed `OK: generated client ran on poagen/client-runtime alone
  (generator absent)` — it never regenerates from the schema, it copies
  the already-committed `examples/petstore/generated/Generated` tree, so it
  stayed green and unaware, reproducing the exact silent-drift failure mode
  the task describes.

The schema edit was reverted (`git checkout --
examples/petstore/schemas/petstore-3.0.yaml`) before this decision was
recorded; `git status` on `examples/` is clean.

=== The network dependency: re-examined, removed

The task asked that the network dependency behind this recipe sitting
outside `just check` be removed, vendored, or explicitly accepted with the
reason recorded — "it has not been re-examined since." It has not been
re-examined because it had not changed: `composer install` in the scratch
project under `build/` required `nyholm/psr7` from `packagist.org`, same as
the day `runtime-package-split` wrote the recipe.

Confirmed the dependency was real before touching anything:
`COMPOSER_DISABLE_NETWORK=1 just verify-runtime-standalone` still printed
`https://repo.packagist.org could not be fully loaded (Network disabled,
request canceled: ...)`, falling back to a locally warm cache rather than
failing — proof this machine's cache was masking a dependency a clean
checkout does not have.

Removed, not vendored or accepted: `nyholm/psr7` and every one of its
transitive requirements (`php-http/discovery`, `phpstan/phpdoc-parser`,
`psr/http-client`, `psr/http-factory`, `psr/http-message`) are already
installed in this repo's own root `vendor/`, the same install `just check`
itself requires before it can run at all (`composer install`, never
`composer update` — CONTRIBUTING.md). The scratch project's
`composer.json` now adds a `path` repository over `vendor/*/*`, forces
each matched package's version from the root `composer.lock` (a path
repository has no version-control metadata of its own to detect a version
from, so without this it would guess this checkout's own git branch name
for every package, which cannot satisfy a real constraint like
`nyholm/psr7`'s `^1.8`), and explicitly disables `packagist.org`. The
version map is generated from `composer.lock` at run time by a `php -r`
one-liner in the script, not copied into it by hand, so it has nothing of
its own to fall out of step with the lockfile the rest of the gate already
trusts. `poagen/client-runtime` is excluded from that generated map — it
keeps its own dedicated `path` repository, unchanged, with the `@dev`
constraint the root project itself uses. `COMPOSER_DISABLE_NETWORK=1` is
now exported by the script itself, so a future dependency this scratch
project needs but this repo has not already vendored fails fast with a
resolution error naming the missing package, rather than silently reaching
the network the way the original recipe always could.

Verified, not merely argued: `just verify-runtime-standalone` still passes
after the change, and passes identically with `http_proxy` /
`https_proxy` pointed at an unreachable address (`http://127.0.0.1:1`) —
every dependency installs via `Symlinking from
.../vendor/<vendor>/<package>`, none via a download.

== Consequences

- `scripts/verify-runtime-standalone` resolves every dependency from this
  repo's own `vendor/` and `runtime/`, never the network — its header
  comment records the re-examination so a future reader does not have to
  re-derive it.
- `tests/Integration/StandaloneHarnessTracksGeneratedApiTest.php` ran
  inside `just check` (via `just test-coverage`) and inside CI's
  `unit-tests` and `coverage` jobs, on every push and pull request against
  `main` — no new recipe, no new workflow, while it existed. It does not
  exist any more — see `=== Superseded` below.
- The pin covered exactly the two shapes the two historical breaks changed
  — `ApiClient`'s constructor arity/order and `getPetById`'s return
  shape — not every shape `run.php` depended on. A future drift in a shape
  the test did not pin (a different endpoint's URI, a header name, the
  stub transport's status-code handling) would still only have been caught
  by running `just verify-runtime-standalone` by hand — a gap this
  decision named as future work and left open. `=== Superseded` below is
  that future work landing.
- `just verify-runtime-standalone` itself is unchanged in what it proves —
  a generated client installing and running on `poagen/client-runtime`
  alone, generator absent — and stays outside `just check`, per the task's
  own non-goal.
- If `vendor/*/*`'s glob ever stops matching a package this scratch
  project needs (a dependency rename, a vendor directory restructuring),
  `composer install` fails with a resolution error naming it, not a
  silent network fallback — `COMPOSER_DISABLE_NETWORK=1` is exported for
  exactly that guarantee.

=== Superseded

This decision was superseded on 2026-08-08 by
#link("derive-the-standalone-consumer-instead-of-pinning-its-shape.decision-260808.typ")[The standalone harness derives its consumer call by reflection instead of pinning its shape as text],
which took the option-2 upgrade path this decision named above as future
work and found it did not need its own task against `src/` or
`examples/petstore/` after all: `scripts/verify-runtime-standalone` already
builds a real, installed copy of the generated tree before running
`run.php` against it, so reading `ApiClient`'s constructor with PHP's own
`ReflectionClass` on that installed class was enough. `run.php` stopped
being hand-written, and `tests/Integration/StandaloneHarnessTracksGeneratedApiTest.php`
— the pin this decision chose — was deleted as redundant rather than kept
beside it. The analysis above is a record of what was known and chosen at
the time and is left unchanged.
