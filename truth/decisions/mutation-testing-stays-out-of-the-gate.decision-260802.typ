#import "@local/speconaut:0.1.0": *
#import "../domain/generation.context.typ": *

#show: decision.with(
  title: "Mutation testing is wired, measured, and stays out of the gate",
  status: accepted(2026, 8, 2),
  contexts: (generation-context,),
  goals: (link("../goals/strict-clean-output.goal.typ"),),
  process-only: "governs poagen's own test-gate configuration (whether and how infection runs against this project's own suite), not what the generator produces or what a reimplementation must do",
)

== Context

`021-infection-wire-up-or-remove.task-260418.typ` retired as `done` by
dropping the `infection/infection` dev dependency rather than wiring it,
on the grounds that the code surface had not stabilised enough for a
mutation score to mean anything. `ROADMAP.md` carried the follow-up as
post-v0.1. Since then the transport collapsed to one class
(`operations-delegate-to-an-injected-transport`), the runtime shipped as
its own package with a declared contract
(`runtime-ships-as-a-separate-package`), and the generator's posture
moved from degrading to refusing
(`fail-loud-never-silent.goal.typ`). `wire-mutation-testing.task-260801.typ`
revisits the question this project has now deferred twice, on the
explicit condition that it not defer a third time: wire mutation testing,
or close the question in writing with the measurement behind it. This
records the outcome — wired, not gated, with the numbers.

Coverage answers a narrower question than the one this project actually
has. `coverage-floor-in-the-gate` measures whether a line ran; it cannot
tell whether anything would have noticed if that line's behaviour were
wrong. On a code generator whose test suite mostly asserts against
emitted strings, a weakened assertion can cover every branch and still
pass — a failure mode this project has hit for real, in the spec whose
step body asserted the opposite of its own scenario. Mutation testing is
the instrument built to answer exactly that question: it changes the
code and checks whether a test actually noticed.

== Choice

=== Wired as a dev dependency, not a hosted service

`composer require --dev infection/infection` added `infection/infection`
`^0.34.1` (pulling in `infection/extension-installer`,
`infection/abstract-testframework-adapter`, and their transitive
dependencies) to `composer.json`'s `require-dev`, with
`config.allow-plugins.infection/extension-installer` set to `true`. This
mirrors `quality-gates-at-maximum-strictness`'s stance against outsourcing
judgement to a hosted number: infection runs locally, against this
project's own suite, the same way phpstan and php-cs-fixer already do.
`composer.lock` is committed so every checkout runs the same pinned
version.

`infection.json5` configures `source.directories` as `src` and
`runtime/src` together — the same two directories
`coverage-floor-in-the-gate` measures, in one combined run rather than two
separate configs, because infection has no per-directory MSI floor of its
own to make splitting them worth the extra config. Reports land under
`build/logs/infection*` and infection's own cache under
`build/cache/infection`, both already covered by `.gitignore`'s existing
`/build/` entry — no new `.gitignore` entries were needed.

=== The PCOV trap, twice over

The devbox-packaged composer leaks a stale `PHP_INI_SCAN_DIR` into script
subprocesses, silently dropping PCOV even though `which php` resolves
correctly — `test-coverage`'s own comment in the `Justfile` names this.
The `mutate` and `mutate-fast` recipes call `vendor/bin/infection`
directly rather than through a composer script, so `env -u
PHP_INI_SCAN_DIR` on the outer invocation is enough to keep PCOV loaded
in infection's own process — confirmed via infection's own `[notice] You
are running Infection with PCOV enabled.` banner. But the fix has to be
threaded a *second* time: infection spawns a child PHP process to run the
initial coverage-generating test suite, and flags passed to infection's
own PHP invocation do not propagate to that child. Without also passing
`-d pcov.directory=. -d 'pcov.exclude=~(vendor|build)~'` via
`--initial-tests-php-options`, that child process silently loses
instrumentation on `runtime/src/` the same way the coverage floor's own
recipe once did (`coverage-floor-in-the-gate`'s "measurement itself
turned out to be wrong" context) — except infection surfaces this failure
mode more bluntly, as every mutant reporting "not covered" regardless of
whether it actually is.

Separately, `vendor/bin/infection`'s default 128M memory limit exhausts
partway through building this run's ~3000 per-mutant test-runner command
lines (observed failing around mutant 1550 of 3049, in
`CommandLineBuilder.php`). `-d memory_limit=2G` on infection's own
invocation fixed it; this has nothing to do with the `PHP_INI_SCAN_DIR`
trap and would recur on any project this size regardless of environment.

=== The measurement: two full runs, both over budget

Two full runs against the combined `src/` + `runtime/src/` source set, on
2026-08-02, `--threads=max` (19 threads, 20-core / 31 GB box):

#table(
  columns: 5,
  [*Run*], [*Wall clock*], [*Mutants*], [*MSI*], [*Killed / Escaped / Timed out / Syntax err*],
  [1], [7m 14s], [3049], [87.77%], [2517 / 373 / 148 / 11],
  [2], [7m 22s], [3049], [87.47%], [2503 / 382 / 155 / 9],
)

Both runs cover *all* of `src/` and `runtime/src/` in a single pass —
nothing was sampled or deferred to fit a time budget, because the run
completed at all, just slower than any budget for routine gating. Broken
out by tier (recomputed from each run's `build/logs/infection.json`,
grouping by mutated file path — infection's own summary does not split
the combined source set):

- `src/`: run 1 MSI 87.85% (2661 mutants); run 2 MSI 87.90% (2661
  mutants). Stable.
- `runtime/src/`: run 1 MSI 86.86% (388 mutants); run 2 MSI 84.28% (388
  mutants). A roughly 2.6-point swing between two runs of the identical
  config against unchanged code — see "MSI has real run-to-run noise"
  below.

Both wall-clock times land far past the "roughly two minutes" budget this
project has already set for gate membership (see
`coverage-floor-in-the-gate` and the jscpd/phpstan recipes' own timings,
none of which come close to seven minutes). Per the standing instruction
for this task, that alone settles the gate question: mutation testing
does **not** join `just check`, `just gate`, or `just gated-check`. It
runs as its own `just mutate` recipe, on its own schedule, run by a human
or CI job that has decided to spend seven-plus minutes on it.

=== A faster path for routine iteration

`just mutate-fast` filters to lines changed against `main`
(`--git-diff-filter=AM --git-diff-base=main`), rather than trusting
infection's own `git:default-base`, which resolves to `origin/master`
here — wrong on both counts, since this repository carries no `origin`
remote and its trunk branch is `main`. Timed against a single
representative file (`src/Generator/Generator.php`, 86 mutants via
`--filter`) at approximately 20 seconds wall-clock including the initial
coverage run — comfortably inside routine-use range, though this is a
proxy measurement (one file, not an actual multi-file diff) rather than a
timing of the `--git-diff-filter` path itself, which had nothing to mutate
against this decision's own diff.

=== infection's own coverage classification is not fully trustworthy for `match`

Both runs reported "Mutation Code Coverage: 100%" and zero "Not Covered"
mutants — every one of the 3049 mutants was classified as reaching
covered code. That figure is wrong for at least two of them. Triage (see
below) found `runtime/src/Marshal/Hydrator.php:70` and
`runtime/src/Marshal/Marshaller.php:61` — the `PropertyType::KIND_MAP`
arm of a `match` expression in each — reported as *escaped* (implying
"covered but undetected") by infection, while a direct
`php -d pcov.directory=. vendor/bin/phpunit --coverage-clover` run shows
both lines at `count=0`: never executed by any test in the suite. The
likely cause is that infection (or the PCOV data it reads) attributes
coverage across the whole multi-line `match` construct rather than
per-arm, so a single arm's execution makes every arm's line read as
"covered." Nothing here changes based on that — the affected mutants are
already filed as `cover-map-kind-round-trip`, and once genuinely covered
they will report correctly — but a future reader comparing infection's
own "Not Covered" count against a raw coverage report should expect them
to disagree for `match`-heavy files, and should not treat infection's
"100% coverage" as proof that every branch actually ran.

=== Weak-assertion triage: two tasks filed, one pattern reviewed and left alone

Filed from a single triage pass over both runs' escaped mutants (382 in
the kept second run), prioritising `runtime/src/` per this task's own
instruction:

- `cover-map-kind-round-trip.task-260802.typ` — the
  `PropertyType::KIND_MAP` round trip through `Hydrator`/`Marshaller` is
  not merely weakly asserted, it is never executed at all (see above). No
  committed fixture, example, or generated model currently produces a
  map-shaped property.
- `cover-methoddocscanner-token-scan.task-260802.typ` —
  `MethodDocScanner`'s attribute-skip and function-name-scan control flow
  (24 escaped mutants, the single highest count of any file in either
  run) genuinely executes, but its only test asserts a single substring
  recovered from a single method on a single fixture file, so the index
  arithmetic the scanner depends on is unpinned.

The largest single escape cluster by mutator — `Concat` and
`ConcatOperandRemoval` together, 115 of 382 escapes — was reviewed and
deliberately **not** filed. It concentrates almost entirely in
hand-written diagnostic and exception messages across the generator's
validators (`ProfileTargetValidator`, `DiscriminatorEnforcer`,
`RequestBodyAnalyzer`, `ResponseAnalyzer`) and `src/Exception/*`. A
concrete example: `ProfileTargetValidator.php:62` builds a `tagRenames`
failure message from two concatenated string literals; the escaped
mutant swaps their order, producing a grammatically broken but still
diagnostically legible message, and the covering scenario step
(`tests/generated/OperationGeneratorSteps.php`,
`thenEntryNamingATagNoOperationCarries...`) asserts
`assertStringContainsString` on two substrings that both survive the
reordering intact. That is a real, structural blind spot in
substring-based assertions — but the messages in question are diagnostic
prose read by a human debugging their own profile, not a machine
contract another part of the system depends on, and every case sampled
still carried the load-bearing substrings a debugging developer needs.
Chasing all 115 would mean either hand-writing exact-message assertions
across a dozen files (brittle, and the antithesis of the substring
approach's original point) or accepting the risk as-is. Recorded here as
reviewed and accepted, not silently skipped.

Two further escape clusters were sampled and judged equivalent rather
than weak: `ReturnRemoval`/`Coalesce` mutants on cache-hit early-returns
and constructor-default `??` fallbacks (e.g.
`DescriptorParser.php:52`, `HttpTransport.php:78-81`) change no
observable behaviour when the code path they short-circuit produces an
identical result either way.

=== No enforced MSI floor, and why not yet

Unlike `coverage-floor-in-the-gate`'s ratchet, this decision does not set
a `--min-msi` / `--min-covered-msi` threshold on `just mutate`. The
measured 2.6-point swing on `runtime/src/` between two back-to-back runs
of unchanged code, at `--threads=max` on a shared 20-core box, is real
noise — plausibly timing-sensitive mutants (loop mutators causing
near-boundary timeouts under contention) landing differently run to run.
A ratchet that only ever moves up, applied to a number with that much
run-to-run variance, would eventually fail on noise alone rather than on
a real regression, and lowering it to compensate defeats the point the
same way lowering the coverage floor would. Setting one is left to a
future decision, once either the variance is brought down (fewer
threads, a longer per-mutant timeout, or both) or a ratchet design that
tolerates it is chosen.

== Consequences

- `just mutate` and `just mutate-fast` exist and work from a fresh
  checkout; neither is part of `just check`, `just gate`, or
  `just gated-check`, and `scripts/gate-fresh.inputs` needs no change
  because nothing added here is read by the gate.
- `composer.json` and `composer.lock` carry `infection/infection` as a
  real, pinned dev dependency — not a mentioned-but-unwired one, closing
  the exact gap `021-infection-wire-up-or-remove` left open.
- `ROADMAP.md`'s "Mutation testing" post-v0.1 follow-up bullet is
  resolved (removed, not left to describe a decision already made) — see
  the same commit.
- A reader who wants a current mutation score reruns `just mutate` rather
  than trusting either number above indefinitely: both are a single
  point-in-time measurement of the commit this task landed on, and MSI
  drifts as `src/` and `runtime/src/` grow.
- `cover-map-kind-round-trip` and `cover-methoddocscanner-token-scan` are
  open, filed tasks — closing either changes what a subsequent `just
  mutate` run reports for that file, and neither blocks anything else in
  this project's queue.
- Anyone comparing infection's own "Not Covered" count against a raw
  `phpunit --coverage-clover` run for a `match`-heavy file should expect
  disagreement (see above) and trust the raw coverage report over
  infection's classification when they conflict.
