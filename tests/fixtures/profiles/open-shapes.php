<?php

/**
 * Profile for the synthetic `open-shapes` schema. Pins the emitted form of all
 * three states of `additionalProperties` — declared `true` beside properties,
 * declared `false`, and omitted entirely — see
 * additional-properties-become-a-typed-bag.
 *
 * tests/Integration/OpenShapesTest.php asserts on emitted source in a sandbox;
 * this golden tree is what puts the runtime bag in front of
 * `lint-phpstan-generated`. Until it existed, that check had been run once by
 * hand in a scratch directory and never again.
 */

declare(strict_types=1);

use Poagen\Generator\Generator\Profile;

// See scratch-output.php: a test run never writes into the committed
// golden tree — that only happens via `just regenerate-fixture open-shapes`.
require_once __DIR__ . '/scratch-output.php';

return new Profile(
    schema: __DIR__ . '/../schemas/open-shapes-3.0.yaml',
    output: poagen_fixture_scratch_output('open-shapes'),
    namespace: 'Poagen\\Generator\\Tests\\Fixtures\\Generated\\OpenShapes',
);
