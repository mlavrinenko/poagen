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
    skip: [
        // /inline-body deliberately carries an inline (non-$ref) JSON
        // request body — paogen only synthesises typed bodies for a $ref
        // to a component schema. See abort-on-unrepresentable-constructs.
        'postInlineBody' => 'inline (non-$ref) application/json request body — paogen does not synthesise a Model from it',
    ],
);
