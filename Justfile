set dotenv-load := false

# List available recipes
default:
    @just --list

# Run all quality checks (lint + test + spec check + drift check)
check: lint test check-specs check-generated-tests check-drift

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

# Static analysis on generated fixtures (consumer-view; ADR-004)
lint-phpstan-generated:
    phpstan analyse -c phpstan-generated.neon --memory-limit=512M

# Check for Rector refactoring opportunities
lint-rector:
    rector --dry-run

# Per-language line-count limits on src/ (ADR-004)
lint-linecop:
    linecop

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
generate-tests:
    #!/usr/bin/env bash
    set -euo pipefail
    speconaut interop extract --format json \
        | speconaut-phpunit \
            --output tests/generated \
            --namespace 'Mlavrinenko\Paogen\Tests\Generated'

# Verify generated tests are up to date (CI-friendly drift check)
check-generated-tests:
    #!/usr/bin/env bash
    set -euo pipefail
    speconaut interop extract --format json \
        | speconaut-phpunit \
            --output tests/generated \
            --namespace 'Mlavrinenko\Paogen\Tests\Generated' \
            --check --strict
