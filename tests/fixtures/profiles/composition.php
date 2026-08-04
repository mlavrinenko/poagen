<?php

/**
 * Profile for the synthetic `composition` schema. Exercises oneOf / anyOf /
 * allOf codegen (T-008).
 */

declare(strict_types=1);

use Poagen\Generator\Generator\Profile;

// See scratch-output.php: a test run never writes into the committed
// golden tree — that only happens via `just regenerate-fixture composition`.
require_once __DIR__ . '/scratch-output.php';

return new Profile(
    schema: __DIR__ . '/../schemas/composition-3.0.yaml',
    output: poagen_fixture_scratch_output('composition'),
    namespace: 'Poagen\\Generator\\Tests\\Fixtures\\Generated\\Composition',
    discoverIn: [
        'Poagen\\Generator\\Tests\\Fixtures\\ValueObject',
    ],
);
