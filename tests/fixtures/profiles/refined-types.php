<?php

/**
 * Profile for the synthetic `refined-types` schema. Pins the emitted form of
 * every PHPDoc narrowing a model property can carry — the two OpenAPI
 * constraints prove (`non-empty-string`, `positive-int`) and the one only a
 * profile can say (`numeric-string`), see refined-phpdoc-types.
 *
 * The golden tree exists for `lint-phpstan-generated`. A narrowed `@param`
 * over a bare native parameter is exactly the shape PHPStan refuses when the
 * two disagree, so the consumer-view analysis is the check that proves the
 * emitted narrowing is legal rather than merely intended — the sandbox tests
 * in `tests/Integration/RefinedPhpDocTypeTest.php` assert what the source says
 * and cannot answer that.
 *
 * The refusals for an override a property cannot carry live in that same test
 * (refuse-a-phpdoctypes-override-the-property-cannot-carry); nothing here can
 * express them, because a profile that fails the run emits no tree to commit.
 */

declare(strict_types=1);

use Poagen\Generator\Generator\Profile;

// See scratch-output.php: a test run never writes into the committed
// golden tree — that only happens via `just regenerate-fixture refined-types`.
require_once __DIR__ . '/scratch-output.php';

return new Profile(
    schema: __DIR__ . '/../schemas/refined-types-3.0.yaml',
    output: poagen_fixture_scratch_output('refined-types'),
    namespace: 'Poagen\\Generator\\Tests\\Fixtures\\Generated\\RefinedTypes',
    phpDocTypes: ['LineItem.amount' => 'numeric-string'],
);
