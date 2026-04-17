set dotenv-load := false

# List available recipes
default:
    @just --list

# Run all quality checks (lint + test + spec check + drift check)
check: lint test check-specs check-generated-tests

# Full pre-commit gate
gate: check

# Run all linters in parallel
lint:
    @echo -n 'cs-fixer phpstan rector' | parallel --will-cite --halt now,fail=1 --delimiter=' ' just lint-{}

# Check code style (PER-CS 2.0 + PHP 8.4)
lint-cs-fixer:
    php-cs-fixer fix --diff --verbose --dry-run

# Static analysis
lint-phpstan:
    phpstan analyse --memory-limit=512M

# Check for Rector refactoring opportunities
lint-rector:
    rector --dry-run

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
    speconaut --root {{ justfile_directory() }} check truth/

# Generate/update PHPUnit test stubs from specs (dogfooding)
generate-tests:
    #!/usr/bin/env bash
    set -euo pipefail
    speconaut --root {{ justfile_directory() }} interop extract --format json \
        | speconaut-phpunit \
            --output {{ justfile_directory() }}/tests/generated \
            --namespace 'Mlavrinenko\Paogen\Tests\Generated'

# Verify generated tests are up to date (CI-friendly drift check)
check-generated-tests:
    #!/usr/bin/env bash
    set -euo pipefail
    speconaut --root {{ justfile_directory() }} interop extract --format json \
        | speconaut-phpunit \
            --output {{ justfile_directory() }}/tests/generated \
            --namespace 'Mlavrinenko\Paogen\Tests\Generated' \
            --check --strict
