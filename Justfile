set dotenv-load := false

# Rector, and PHPStan when no `tmpDir` is configured, compile a DI container
# into $TMPDIR and key it by config hash — not by checkout. The default is a
# machine-wide /tmp path, so containers built by one worktree are reused by
# another, and a deleted worktree leaves absolute paths baked into a cache a
# later run still hits. The symptom is an opaque worker-spawn failure that
# reads like a tool regression: `Process "..." not found`, or a Phar path that
# does not exist. Scoping it per checkout makes the cache follow the tree that
# built it, and `just clean` can then actually clear it.
export TMPDIR := justfile_directory() / "build/cache/tmp"

# List available recipes
default:
    @just --list

# Ensure the per-checkout tool cache exists (see TMPDIR above)
[private]
tmpdir:
    @mkdir -p "{{ TMPDIR }}"

# Run all quality checks (lint + test + speconaut check-specs)
#
# The speconaut recipes below were out of this aggregate for months under a
# wrong diagnosis: an earlier version of this comment blamed `speconaut
# check` reading paogen's `.mindtape/config.toml` through a stale embedded
# mindtape parser that rejected keys `mt` itself writes. That was never the
# actual cause and is not preserved here because it is wrong — the real
# cause was upstream of any config: speconaut's own Cargo workspace did not
# resolve (its manifest pointed at `../mindtape/crates/swhid-mint`, a path
# dependency that no longer existed in the mindtape checkout), so it could
# not rebuild and the installed binary stayed frozen at a July build, long
# before any of these recipes could run against paogen's current tree or
# CLI. The toolchain was healed 2026-07-31: the workspace resolves, the
# installed binary is current, and `speconaut check truth/` runs clean — 4
# features, 0 warnings (down from 31, all `task lifecycle provenance`; see
# `declare-paogen-runs-no-sessions`).
#
# All three are in the gate now. `check-drift` and `check-generated-tests`
# needed `tests/generated/manifest.json`, which only a real `generate-tests`
# run produces — and that run appended ~200 `Implement:` stubs plus 149
# orphaned step methods, so neither recipe could pass until the step bodies
# caught up with the specs. They have: the 149 orphans were the stubs' old
# names, their bodies rehomed, and the generated suite went 77 tests to 93
# with no failures. The lockfile was refreshed the same day, first time
# since April — 88 scenarios, 565 traces.
#
# Runs `test-coverage`, not a bare `test` (coverage-floor-in-the-gate): the
# suite under coverage takes ~9s against ~6s bare, so running it once here
# with the floor enforced costs less than running it twice — once bare for
# `check`, once under coverage for a recipe nothing else called. `just
# test` stays the fast, uninstrumented path for local iteration.
check: tmpdir lint test-coverage check-specs check-drift check-generated-tests

# Full pre-commit gate
gate: check

# Run the full gate and record that it passed against this worktree, so the
# freshness predicate on `mt flip ... done` can assert it without re-running
# the gate inside the flip. Prefer this over a bare `just check` when you are
# about to close a task — a bare run proves the tree is good but records
# nothing, and the flip will refuse for want of evidence rather than merit.
gated-check: check
    scripts/gate-fresh record

# Run all linters in parallel
lint: tmpdir
    @echo -n 'cs-fixer phpstan phpstan-generated rector linecop jscpd jscpd-generated' | parallel --will-cite --halt now,fail=1 --delimiter=' ' just lint-{}

# Check code style (PER-CS 2.0 + PHP 8.4)
#
# Needs `tmpdir`: php-cs-fixer spawns its parallel workers through PHP's
# sys_get_temp_dir(), which is $TMPDIR (see the export at the top of this
# file) — a bare `just lint-cs-fixer` in a fresh checkout dies with
# "Failed creating temp file as sys_get_temp_dir=... is not writable"
# without this dependency, dry-run or not.
lint-cs-fixer: tmpdir
    php-cs-fixer fix --diff --verbose --dry-run

# Static analysis on src/
lint-phpstan: tmpdir
    phpstan analyse --memory-limit=512M

# Static analysis on generated fixtures (consumer-view; ADR-004), plus a
# fan-out into every example's own check (examples-check-themselves).
#
# tests/fixtures/generated isn't owned by any example, so it is analysed
# directly, here, against phpstan-generated.neon exactly as before. Every
# examples/*/ directory now carries its own Justfile and its own
# phpstan.neon (which `includes:` this file, so it is held to the identical
# no-baseline / no-excludePaths / no-ignoreErrors max-level absolute), and
# decides its own path set — `generated/` when it exists, `src/` when it
# exists (that tier assignment for hand-written consumer code is explained
# in examples/<name>/Justfile, not here), skipped entirely when neither does
# (the .expected-failure examples). This recipe no longer assembles that
# path list itself: it just runs each example's own `check`, the same
# recipe you'd run by hand from inside that directory, so a regression in
# any example tree fails here exactly the way it fails standalone.
lint-phpstan-generated: tmpdir
    #!/usr/bin/env bash
    set -eo pipefail
    phpstan analyse -c phpstan-generated.neon --memory-limit=512M tests/fixtures/generated
    for dir in examples/*/; do
        name=$(basename "$dir")
        echo "== $name =="
        (cd "$dir" && just check)
    done

# Check for Rector refactoring opportunities
lint-rector: tmpdir
    rector --dry-run

# Per-language line-count limits on src/ (ADR-004)
lint-linecop:
    linecop

# Duplication gate on src/ and tests/ (source tier; jscpd-as-a-real-gate)
#
# A file's preamble is repeated text that says nothing about duplicated
# logic: two files importing the same eight symbols are not two copies of
# an idea. So `.jscpd.json` drops `declare`, `namespace` and top-level
# `use` lines with an `ignorePattern` before detection, which lets
# `minTokens` sit at jscpd's default 50 and still report zero header
# matches in src/. Raising the threshold instead was the first attempt and
# the wrong one: 84 was needed to bury the noise, and it buried every
# genuine short clone with it.
#
# The pattern is anchored to column 0 (`(?m)^`), so a trait `use` inside a
# class body — which is real code — still counts. Only the preamble goes.
#
# `--threshold` gates on jscpd's own "Total duplicated lines" percentage
# across every format it scans (json + php + yaml under src/ and tests/), the
# same figure the console table prints. Measured on 2026-08-01: 4.99%
# duplicated lines (3.13% duplicated tokens), 90 clones. 5.5% is set just
# above that so the gate is green today and has a little room before it
# trips on incidental noise, not to license new duplication.
#
# RATCHET: this number only ever moves DOWN, as real duplication (see
# deduplicate-the-test-suite) is removed and the measured figure drops.
# Raising it to let a change land is not a fix, it is disabling the gate —
# fix the duplication or take it to the owner instead.
#
# Do not add `--exit-code` alongside `--threshold`: jscpd's `--exit-code`
# fails on ANY clone found regardless of the threshold, so combining the two
# would fail today even though 4.99% is under 5.5%. `--threshold` alone
# already sets the exit code (0 under the limit, 1 over it) — verified by
# probing 4.9 (fails: "found too many duplicates (5.0%) over threshold
# (4.9%)") and 5.5 (passes) against the same tree. (If you do reach for
# `--exit-code` on its own elsewhere, always give it an explicit value —
# spelled bare it eats the next positional argument.)
#
# `examples/*/src` is hand-written consumer code and belongs in THIS tier, not
# the generated one, even though lint-phpstan-generated puts it in that tier.
# The two recipes divide the tree for different reasons: phpstan asks "whose
# strictness standard applies", and consumer code answers "the consumer's".
# jscpd asks "what is this number measuring", and a duplication figure over
# output plus hand-written code measures neither. Measured 2026-08-01: 5.09%
# duplicated lines (3.17% tokens), 92 clones.
#
# deduplicate-the-test-suite moved nine tests/Integration/ files onto
# tests/Support/GeneratedTreeSandbox.php's shared sandbox-dir, composer-loader,
# generator-construction and CLI-invocation helpers — repeated scaffolding
# that never carried the schema, the profile or the expectation a test
# actually asserted on, so pulling it out left every one of those visible at
# the call site. What remained (tests/generated/, the emitted fixture trees,
# a schema fixture, and a handful of same-shape assertions or test doubles
# that ARE a test's subject) was left alone on purpose. Measured 2026-08-01:
# 3.36% duplicated lines (2.38% tokens), 76 clones. 3.5% is set just above
# that: green today, minimal slack, no license to add more duplication.
#
# RATCHET: this number only ever moves DOWN. Never raise it to admit a clone.
lint-jscpd:
    #!/usr/bin/env bash
    set -eo pipefail
    shopt -s nullglob
    paths=(src runtime/src tests examples/*/src)
    jscpd -c .jscpd.json --threshold 3.5 "${paths[@]}"

# Duplication gate on generated fixtures + example trees (generated tier;
# jscpd-as-a-real-gate)
#
# Resolves its path set the way lint-phpstan-generated does: not every
# example has a generated/ directory (some are .expected-failure), so
# nullglob keeps a run with zero example trees from erroring on a literal
# unmatched glob instead of falling back to tests/fixtures/generated alone.
#
# Generated output legitimately duplicates more than hand-written source —
# RequestAssembler/ResponseHandler-shaped code repeats per operation — so
# this tier gets its own, looser threshold rather than sharing lint-jscpd's.
#
# The path set is emitted output ONLY. `examples/*/src` is hand-written and
# lives in lint-jscpd; including it here diluted the figure to 15.11% and hid
# that output alone was already at 16.01% — over the threshold that number had
# been used to justify. A duplication gate whose denominator includes code the
# generator did not write cannot measure the generator.
#
# Measured on 2026-08-01, emitted output alone: 16.01% duplicated lines
# (32.11% duplicated tokens), 36 clones. 16.5% is set just above that: green
# today, minimal slack, no license to add more duplication.
#
# RATCHET: this number only ever moves DOWN as emitted duplication is
# collapsed further. Never raise it to accommodate a new clone.
lint-jscpd-generated:
    #!/usr/bin/env bash
    set -eo pipefail
    shopt -s nullglob
    paths=(tests/fixtures/generated examples/*/generated)
    jscpd -c .jscpd.json --threshold 16.5 "${paths[@]}"

# Auto-fix code style
#
# Needs `tmpdir` for the same reason `lint-cs-fixer` does — see its comment.
# A fresh worktree that hasn't run `just check` yet dies with "Failed
# creating temp file as sys_get_temp_dir=... is not writable" otherwise.
format: tmpdir
    php-cs-fixer fix --diff --verbose

# Apply Rector refactorings
#
# Needs `tmpdir`: rector compiles its DI container into $TMPDIR (see the
# export at the top of this file and `lint-rector`'s identical dependency);
# without it a fresh worktree fails with `The path "..." is not a
# directory.`
format-rector: tmpdir
    rector

# Run tests
test: tmpdir
    phpunit

# Run tests with coverage and enforce the per-tier statement-coverage floor
# (coverage-floor-in-the-gate). Same `tmpdir` need as `test` — some
# integration tests (e.g. tests/Support/GeneratedTreeSandbox.php) write
# through sys_get_temp_dir().
#
# `-d pcov.directory=.` is not decoration. PCOV auto-detects `pcov.directory`
# from the working directory, and that auto-detection lands on `<repo>/src`
# — verified via `php -i | grep pcov.directory` under a bare `phpunit
# --coverage-clover ...` invocation from the repo root. `runtime/src/` sits
# outside that auto-detected root and is never instrumented, so an
# unconfigured run reports it at a flat 0.00%: an artifact of the wrong
# instrumentation root, not a fact about the runtime package's tests.
# Setting `pcov.directory` to the repo root explicitly (with `vendor` and
# `build` excluded, so vendored and generated code is never scanned) fixes
# it for every tier phpunit.xml.dist's `<source>` lists. `composer
# test:coverage` (which CI's coverage job runs) sets the same two flags for
# the same reason — this is not the only place PCOV could silently regress
# back to the broken default. It additionally runs under `env -u
# PHP_INI_SCAN_DIR`: in this devbox environment, composer's own binary
# leaks a stale `PHP_INI_SCAN_DIR` (pointing at an older, pcov-less
# `php-with-extensions` build) into every script it spawns, which silently
# drops pcov from the child `php` process even though `which php` still
# resolves to the correct, current build — verified via `php -d
# pcov.directory=. -m | grep pcov` under `composer test:coverage` with and
# without the `env -u`. This recipe invokes `php` directly, not through
# composer, so it never inherits that override and does not need the fix.
#
# Measured on 2026-08-01 with instrumentation fixed: src/ 87.50%,
# runtime/src/ 88.39%, combined 87.64% (statement coverage, clover). The
# same commit measured with the auto-detected (broken) directory: src/
# 87.46%, runtime/src/ 0.00%, combined 73.35% — the gap is entirely the
# instrumentation bug above, not a real difference in what either tier's
# tests exercise.
#
# SCOPE (coverage-floor-in-the-gate decision): src/ and runtime/src/ count.
# tests/fixtures/generated and examples/*/generated do not — emitted code is
# tool product already gated by the generated-tier PHPStan config, the
# byte-stability fixtures and `just check-examples`, and counting it would
# inflate the figure with code no human wrote. phpunit.xml.dist's <source>
# only lists src/ and runtime/src/, so emitted code never reaches the
# clover report to begin with; nothing here has to exclude it a second time.
#
# TWO FLOORS, NOT ONE: runtime/src/ ships as its own package
# (runtime-ships-as-a-separate-package), so it is measured and gated
# separately from src/ — a single blended number would let a regression in
# either tier hide behind the other's tests.
#
# RATCHET: these two floors only ever move UP, as real tests raise the
# measured figure. Lowering one to let a change land is not a fix, it is
# disabling the gate — write the missing test or take it to the owner
# instead. Conversely, never raise either number by writing a test that
# asserts nothing just to hit it (coverage-floor-in-the-gate's non-goal) —
# a floor met that way is worse than no floor.
test-coverage: tmpdir
    #!/usr/bin/env bash
    set -eo pipefail
    php -d pcov.directory=. -d 'pcov.exclude=~(vendor|build)~' vendor/bin/phpunit --coverage-html build/coverage --coverage-clover build/logs/clover.xml
    scripts/coverage-floor build/logs/clover.xml src=87.0 runtime/src=88.0

# Prove a generated client installs and runs on mlavrinenko/paogen-runtime
# alone, with the generator absent (runtime-package-split). Builds a scratch
# composer project under build/ — not part of `just check`: it resolves
# nyholm/psr7 from the network/cache, which the offline gate does not assume.
verify-runtime-standalone: tmpdir
    scripts/verify-runtime-standalone

# Install dependencies and local git hooks
install: install-hooks
    composer install

# Point git at .githooks/ so commit-msg enforces the task-trailer policy
# (require-a-task-trailer-on-every-commit). Idempotent — safe to re-run.
install-hooks:
    git config core.hooksPath .githooks
    @echo "git hooks installed: core.hooksPath -> .githooks"

# Update dependencies
update:
    composer update

# Verify every commit in a range carries a resolvable task reference
# (require-a-task-trailer-on-every-commit). Same rule the commit-msg hook
# enforces on new commits, run instead over existing history — for CI, or a
# human auditing a branch. Usage: `just check-commit-trailers origin/main..HEAD`.
check-commit-trailers range:
    .githooks/check-task-trailers --range '{{ range }}'

# Clean generated artifacts
clean:
    rm -rf build/cache build/coverage build/logs

# Check specs via speconaut
check-specs:
    speconaut check truth/

# Verify no spec/source drift (lockfile current with traces)
#
# `speconaut lock --check` is the purpose-built form: read-only, and it
# skips the session gate by design so it runs in CI. It replaced a pipeline
# that counted `content_mismatches` out of `speconaut status --format json`
# through php. That pipeline reported drift the recipe did not have —
# `status` exits 1 whenever it has anything to report at all, including
# ordinary debt like untraced features and process-only decisions, so under
# `pipefail` it failed before counting anything. Measured: exit 1 with
# `content_mismatches: 0`.
#
# Proven to detect real drift rather than merely exiting 0: editing one
# scenario's `#then` moves it to exit 1 and `content_mismatches: 1`, and
# reverting returns it to 0.
#
# Needs `tmpdir`: `lock` spawns the PHP adapter (speconaut-php-phpunit) to
# audit traces, and that subprocess dies (exit 255) when $TMPDIR points at a
# directory that doesn't exist yet — a bare `just check-drift` in a fresh
# worktree hits this without the dependency.
check-drift: tmpdir
    speconaut lock --check

# Generate/update PHPUnit test stubs from specs (dogfooding)
#
# `speconaut interop extract --format json | speconaut-phpunit ...` is
# gone: test generation is one subcommand now, and `--namespace` moved off
# the CLI entirely onto `.speconaut/config.toml`'s top-level `namespace`
# key (a PHP namespace is backslash-separated; a shell-quoted CLI flag
# can't carry that as safely as a TOML literal string can).
#
# Needs `tmpdir` for the same reason `check-drift` does (the PHP adapter)
# and because it shells out to `just format`, which needs it too — a bare
# `just generate-tests` in a fresh worktree fails with "sys_get_temp_dir is
# not writable" otherwise.
generate-tests: tmpdir
    speconaut generate-tests truth/ --adapter php-phpunit --output tests/generated
    just format

# Verify generated tests are up to date (CI-friendly drift check)
#
# `--check` alone; there is no `--strict`, and `--check` already fails on
# any warning, which is what `--strict` used to mean.
#
# This sat outside the gate while paogen's specs had outrun their step
# bodies: regenerating appended ~200 `Implement:` stubs and reported 149
# orphaned step methods, and either alone fails `--check`. Both are gone —
# the 149 orphans were the old names of the stubs, their bodies rehomed to
# the renamed steps.
check-generated-tests:
    speconaut generate-tests truth/ --adapter php-phpunit --output tests/generated --check

# Run each examples/*/ profile through paogen; report pass / drift /
# expected-failure. Deliberately NOT wired into `just check` — broken
# examples are committed as targets for upcoming work (see T-024).
check-examples:
    #!/usr/bin/env bash
    set -uo pipefail
    fails=0
    stale=0
    for profile in examples/*/paogen.php; do
        dir=$(dirname "$profile")
        name=$(basename "$dir")
        if [[ -f "$dir/.expected-failure" ]]; then
            if php -d memory_limit=2G bin/paogen generate --dry-run "$profile" >/dev/null 2>&1; then
                echo "❌ $name: marked expected-failure but generator now succeeds"
                echo "   → delete $dir/.expected-failure and commit the generated/ tree"
                stale=$((stale + 1))
            else
                reason=$(head -n 1 "$dir/.expected-failure")
                echo "⚠️  $name: expected-failure — $reason"
                if [[ -d "$dir/generated" ]]; then
                    echo "❌ $name: expected-failure but generated/ is still committed"
                    echo "   → delete $dir/generated/ — it is stale output no current run reproduces"
                    stale=$((stale + 1))
                fi
            fi
        else
            if php -d memory_limit=4G bin/paogen generate --diff "$profile" > /tmp/paogen-examples-diff.$$ 2>&1; then
                echo "✅ $name: no drift"
            else
                echo "❌ $name: drift or error"
                cat /tmp/paogen-examples-diff.$$
                fails=$((fails + 1))
            fi
            rm -f /tmp/paogen-examples-diff.$$
        fi
    done
    if [[ $fails -gt 0 || $stale -gt 0 ]]; then
        echo ""
        echo "check-examples: $fails unexpected failure(s), $stale stale marker(s)"
        exit 1
    fi
    echo ""
    echo "check-examples: all examples in expected state"

# Gather the input for a decisions audit over a set of closed tasks.
#
# Deliberately NOT in `just check`, and not a gate of any kind: it reads,
# prints, and exits 0 whatever it finds. The human review gate this
# replaces died of being a queue nobody could service
# (review-gate-must-be-mechanical), so this one blocks nothing — it
# assembles what a reader needs and stops there.
#
# The brief is the input, not the audit. `truth/notes/decisions-audit-
# procedure.md` carries the rubric that turns one into the other, and
# `scripts/audit-decisions --help` points at it.
#
# The argument is an `mt` filter expression, so any view works:
# `just audit-decisions '@recent'`, or an explicit set. Note `mt`'s filter
# grammar has no field for the date a status was reached, so "everything
# closed on a given day" is not expressible as a filter — the 2026-08-01
# validation run derived its set from `mt ls @recent --format json` and
# passed it explicitly; the report records the command.
audit-decisions filter='@recent':
    scripts/audit-decisions '{{ filter }}'
