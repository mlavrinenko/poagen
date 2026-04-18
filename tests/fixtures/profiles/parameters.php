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
);
