set dotenv-load := false

# List available recipes
default:
    @just --list

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
# `check-specs` is restored to the gate below. `check-drift` and
# `check-generated-tests` stay out — both need `tests/generated/
# manifest.json`, which does not exist because these recipes have never
# run `generate-tests` for real, and producing it means accepting the
# ~200 outstanding `Implement:` step stubs (plus 149 now-orphaned step
# methods) that `implement-the-outrun-step-bodies` owns, not this one. See
# each recipe's own comment for specifics.
check: lint test check-specs

# Full pre-commit gate
gate: check

# Run all linters in parallel
lint:
    @echo -n 'cs-fixer phpstan phpstan-generated rector linecop' | parallel --will-cite --halt now,fail=1 --delimiter=' ' just lint-{}

# Check code style (PER-CS 2.0 + PHP 8.4)
lint-cs-fixer:
    php-cs-fixer fix --diff --verbose --dry-run

# Static analysis on src/
lint-phpstan:
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
lint-phpstan-generated:
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
lint-rector:
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
test:
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
# NOT wired into `check`. The command below is already correct against the
# current CLI and schema — `speconaut status --format json-schema` confirms
# `content_mismatches` is a live field today, not a retired one an earlier
# draft of this task assumed it was. What blocks this recipe is data, not
# wiring: `status` (like `lock`) unconditionally spawns the php-phpunit
# adapter to resolve coverage-derived traces via `tests/generated/
# manifest.json`, and that file does not exist — these recipes have never
# run `generate-tests` for real. The adapter's `audit-traces` RPC has no
# fallback for a missing manifest by design (fails loud rather than
# reporting empty traces), so this hard-errors today instead of reporting
# drift. `implement-the-outrun-step-bodies` unblocks it: once a real
# `generate-tests` run lands a `manifest.json`, this recipe starts working
# and can move into `check`.
check-drift:
    #!/usr/bin/env bash
    set -euo pipefail
    n=$(speconaut status --format json \
        | php -r 'echo count(json_decode(stream_get_contents(STDIN), true)["content_mismatches"] ?? []);')
    if [[ "$n" -ne 0 ]]; then
        speconaut status >&2
        exit 1
    fi
    echo "speconaut: no drift (0 content_mismatches)"

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
# NOT wired into `check`. Syntactically correct today (`--adapter
# php-phpunit`, no `--strict` — `--check` alone already fails on any
# warning, which is what `--strict` used to mean), but regenerating right
# now would append roughly 200 outstanding `Implement:` step stubs —
# paogen's specs outran their implemented step bodies while these recipes
# sat unwired — and separately reports 149 `orphaned step` warnings for
# step methods no current scenario references. Either alone fails
# `--check`. Both are real content changes `tests/generated/` needs, not a
# wiring problem, and both belong to `implement-the-outrun-step-bodies`.
# Move this into `check` once that lands and a real `generate-tests` run
# is clean.
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
