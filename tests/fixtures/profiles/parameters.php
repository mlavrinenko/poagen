<?php

/**
 * Profile for the synthetic `parameters` schema. Demonstrates $ref-to-
 * Parameter resolution and PathItem-level parameter inheritance.
 */

declare(strict_types=1);

use Mlavrinenko\Paogen\Generator\Profile;

return new Profile(
    schema: __DIR__ . '/../schemas/parameters-3.0.yaml',
    output: __DIR__ . '/../generated/parameters',
    namespace: 'Mlavrinenko\\Paogen\\Tests\\Fixtures\\Generated\\Parameters',
    discoverIn: [
        'Mlavrinenko\\Paogen\\Tests\\Fixtures\\ValueObject',
    ],
    // /inline-body carries an inline (non-$ref) JSON request body. It used to
    // need a `skip` entry; inline-body-and-response-schemas synthesises a Model
    // for it, so the entry went stale and the run said so rather than ignoring
    // it — see abort-on-unrepresentable-constructs.
);
