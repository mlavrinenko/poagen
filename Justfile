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
check: tmpdir lint test check-specs check-drift check-generated-tests

# Full pre-commit gate
gate: check

# Run all linters in parallel
lint: tmpdir
    @echo -n 'cs-fixer phpstan phpstan-generated rector linecop' | parallel --will-cite --halt now,fail=1 --delimiter=' ' just lint-{}

# Check code style (PER-CS 2.0 + PHP 8.4)
lint-cs-fixer:
    php-cs-fixer fix --diff --verbose --dry-run

# Static analysis on src/
lint-phpstan: tmpdir
    phpstan analyse --memory-limit=512M

# Static analysis on generated fixtures + example trees (consumer-view; ADR-004)
#
# phpstan-generated.neon has no `paths:` (PHPStan errors on a path that
# doesn't exist, and not every examples/*/generated tree exists — some
# examples are .expected-failure and have no generated/ dir). So the path
# set is resolved here: tests/fixtures/generated is always analysed, and
# examples/*/generated is glob-expanded to whichever example trees
# currently exist (nullglob so a run with zero example trees still
# analyses the fixtures instead of erroring on a literal unmatched glob).
lint-phpstan-generated: tmpdir
    #!/usr/bin/env bash
    set -euo pipefail
    shopt -s nullglob
    # `examples/*/src` is hand-written consumer code, not output — the decorator
    # that proves the wrapper architecture works lives there. It belongs in this
    # tier rather than the generator's: it is exactly the code a consumer writes
    # against an emitted interface, so it should be held to the standard their own
    # project would hold it to.
    paths=(tests/fixtures/generated examples/*/generated examples/*/src)
    phpstan analyse -c phpstan-generated.neon --memory-limit=512M "${paths[@]}"

# Check for Rector refactoring opportunities
lint-rector: tmpdir
    rector --dry-run

# Per-language line-count limits on src/ (ADR-004)
lint-linecop:
    linecop

# Duplication report on src/ and tests/ (report-only for now)
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
# NOT wired into `lint`: `lint` uses `parallel --halt now,fail=1`, and a
# report-only recipe in there is noise nobody reads. This recipe reports
# rather than fails because the duplication it finds has not been removed
# yet — collapse-operations-onto-a-runtime-transport and
# deduplicate-the-test-suite do that. Once they land, add `--exit-code 1`
# here (always give --exit-code an explicit value — spelled bare it eats the
# next positional argument) and fold this into `lint`.
lint-jscpd:
    jscpd -c .jscpd.json src/ tests/

# Duplication report on generated fixtures + example trees (report-only for now)
#
# Resolves its path set the way lint-phpstan-generated does: not every
# example has a generated/ directory (some are .expected-failure), so
# nullglob keeps a run with zero example trees from erroring on a literal
# unmatched glob instead of falling back to tests/fixtures/generated alone.
#
# NOT wired into `lint` — see lint-jscpd above for why, and which tasks flip
# both recipes to failing.
lint-jscpd-generated:
    #!/usr/bin/env bash
    set -euo pipefail
    shopt -s nullglob
    paths=(tests/fixtures/generated examples/*/generated examples/*/src)
    jscpd -c .jscpd.json "${paths[@]}"

# Auto-fix code style
format:
    php-cs-fixer fix --diff --verbose

# Apply Rector refactorings
format-rector:
    rector

# Run tests
test: tmpdir
    phpunit

# Run tests with coverage
test-coverage:
    phpunit --coverage-html build/coverage --coverage-clover build/logs/clover.xml

# Install dependencies
install:
    composer install

# Update dependencies
update:
    composer update

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
check-drift:
    speconaut lock --check

# Generate/update PHPUnit test stubs from specs (dogfooding)
#
# `speconaut interop extract --format json | speconaut-phpunit ...` is
# gone: test generation is one subcommand now, and `--namespace` moved off
# the CLI entirely onto `.speconaut/config.toml`'s top-level `namespace`
# key (a PHP namespace is backslash-separated; a shell-quoted CLI flag
# can't carry that as safely as a TOML literal string can).
generate-tests:
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
