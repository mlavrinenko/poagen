<?php

/**
 * Profile for the synthetic `parameters` schema. Demonstrates $ref-to-
 * Parameter resolution and PathItem-level parameter inheritance.
 */

declare(strict_types=1);

use Poagen\Generator\Generator\Profile;

// See scratch-output.php: a test run never writes into the committed
// golden tree — that only happens via `just regenerate-fixture parameters`.
require_once __DIR__ . '/scratch-output.php';

return new Profile(
    schema: __DIR__ . '/../schemas/parameters-3.0.yaml',
    output: poagen_fixture_scratch_output('parameters'),
    namespace: 'Poagen\\Generator\\Tests\\Fixtures\\Generated\\Parameters',
    discoverIn: [
        'Poagen\\Generator\\Tests\\Fixtures\\ValueObject',
    ],
    // /inline-body carries an inline (non-$ref) JSON request body. It used to
    // need a `skip` entry; inline-body-and-response-schemas synthesises a Model
    // for it, so the entry went stale and the run said so rather than ignoring
    // it — see abort-on-unrepresentable-constructs.
);
