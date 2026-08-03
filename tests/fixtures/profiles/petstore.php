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
    // `uploadFile` was skipped here for its `application/octet-stream` body
    // until represent-non-json-request-and-response-bodies gave that body a
    // `Psr\Http\Message\StreamInterface` parameter. Nothing in this document
    // is unrepresentable now, so there is no skip list — and leaving the
    // entry would fail the run as stale rather than pass quietly.
);
