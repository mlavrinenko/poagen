<?php

declare(strict_types=1);

/**
 * Scratch output root for every profile in this directory
 * (fixtures-generate-to-a-scratch-tree).
 *
 * Every profile here used to point `output:` straight at its own golden
 * tree under `tests/fixtures/generated/`, so a plain test run — which loads
 * a profile and calls `Generator::generate()` on it, in
 * `tests/generated/*Steps.php` — regenerated the committed golden in place.
 * Harmless while the generator agrees with the golden byte for byte; not
 * harmless the moment it is deliberately wrong. A mutant of `camelize()`
 * proved it on 2026-08-02: it left `$ApiKey` for `$apiKey` inside
 * `tests/fixtures/generated/parameters/Generated/ApiClient.php`, tracked and
 * indistinguishable from real work.
 *
 * Every profile below now writes here instead, and nothing under
 * `tests/fixtures/generated/` is ever a default write target again.
 * `tests/Integration/ByteStabilityTest.php` (and any sibling doing the same)
 * is what actually compares fresh output against the committed golden.
 * Regenerating a golden tree on purpose is still supported — `just
 * regenerate-fixture <name>`, documented in CONTRIBUTING.md — via the CLI's
 * own `--output` override (`GenerateCommand::withOutput()`, covered by
 * `OutputOverrideCarriesEveryProfileFieldTest`), which is unaffected by what
 * a profile declares as its default.
 *
 * This does not invent a new temp-directory convention: `sys_get_temp_dir()`
 * already resolves per checkout under `just` — the Justfile exports
 * `TMPDIR` to `build/cache/tmp` for every recipe, `tests/Support/
 * GeneratedTreeSandbox.php`'s sandbox helpers already rely on the same
 * resolution, and `just clean` already sweeps it.
 *
 * A real, typed function declaration rather than a value handed back from
 * `require` — PHPStan cannot infer a type through a dynamic `require`
 * expression, so every profile below must pull this in with `require_once`
 * (never a bare `require`: this file declares a global symbol, and a second
 * `require` of it within the same process is a fatal redeclaration).
 */
function paogen_fixture_scratch_output(string $name): string
{
    return sys_get_temp_dir() . '/paogen-fixtures-generated/' . $name;
}
