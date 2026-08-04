<?php

/**
 * Profile for the synthetic `widened-shapes` schema. Pins the emitted form of
 * the three sites that used to answer a declared shape with `mixed` or a bare
 * array — see close-the-three-sites-that-widen-a-declared-shape.
 *
 * tests/Integration/WidenedShapesTest.php asserts on a plan built in memory;
 * this golden tree is what puts the same output in front of
 * `lint-phpstan-generated`, which runs at max with no baseline and no
 * ignoreErrors. The map-valued response types and the AdditionalProperties
 * attribute reach that analysis only from here.
 */

declare(strict_types=1);

use Poagen\Generator\Generator\Profile;

// See scratch-output.php: a test run never writes into the committed
// golden tree — that only happens via `just regenerate-fixture widened-shapes`.
require_once __DIR__ . '/scratch-output.php';

return new Profile(
    schema: __DIR__ . '/../schemas/widened-shapes-3.0.yaml',
    output: poagen_fixture_scratch_output('widened-shapes'),
    namespace: 'Poagen\\Generator\\Tests\\Fixtures\\Generated\\WidenedShapes',
);
