<?php

/**
 * Profile for the synthetic `composition` schema. Exercises oneOf / anyOf /
 * allOf codegen (T-008).
 */

declare(strict_types=1);

use Mlavrinenko\Paogen\Generator\Profile;

// See scratch-output.php: a test run never writes into the committed
// golden tree — that only happens via `just regenerate-fixture composition`.
require_once __DIR__ . '/scratch-output.php';

return new Profile(
    schema: __DIR__ . '/../schemas/composition-3.0.yaml',
    output: paogen_fixture_scratch_output('composition'),
    namespace: 'Mlavrinenko\\Paogen\\Tests\\Fixtures\\Generated\\Composition',
    discoverIn: [
        'Mlavrinenko\\Paogen\\Tests\\Fixtures\\ValueObject',
    ],
);
