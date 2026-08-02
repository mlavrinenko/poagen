<?php

/**
 * Sample paogen profile for the Petstore 3.0 fixture.
 */

declare(strict_types=1);

use Mlavrinenko\Paogen\Generator\Profile;

// See scratch-output.php: a test run never writes into the committed
// golden tree — that only happens via `just regenerate-fixture petstore`.
require_once __DIR__ . '/scratch-output.php';

return new Profile(
    schema: __DIR__ . '/../schemas/petstore-3.0.yaml',
    output: paogen_fixture_scratch_output('petstore'),
    namespace: 'Mlavrinenko\\Paogen\\Tests\\Fixtures\\Generated\\Petstore',
    discoverIn: [
        'Mlavrinenko\\Paogen\\Tests\\Fixtures\\ValueObject',
    ],
    skip: [
        // multipart/octet-stream request bodies are unrepresentable —
        // paogen emits JSON and form-urlencoded bodies only. See
        // abort-on-unrepresentable-constructs.
        'uploadFile' => 'application/octet-stream request body — paogen does not support binary bodies',
    ],
);
