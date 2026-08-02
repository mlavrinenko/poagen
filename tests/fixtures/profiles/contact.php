<?php

/**
 * Profile for the synthetic `contact` schema. Demonstrates BindsFormat.
 */

declare(strict_types=1);

use Mlavrinenko\Paogen\Generator\Profile;

// See scratch-output.php: a test run never writes into the committed
// golden tree — that only happens via `just regenerate-fixture contact`.
require_once __DIR__ . '/scratch-output.php';

return new Profile(
    schema: __DIR__ . '/../schemas/contact-3.0.yaml',
    output: paogen_fixture_scratch_output('contact'),
    namespace: 'Mlavrinenko\\Paogen\\Tests\\Fixtures\\Generated\\Contact',
    discoverIn: [
        'Mlavrinenko\\Paogen\\Tests\\Fixtures\\ValueObject',
    ],
);
