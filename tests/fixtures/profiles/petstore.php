<?php

/**
 * Sample paogen profile for the Petstore 3.0 fixture.
 */

declare(strict_types=1);

use Mlavrinenko\Paogen\Generator\Profile;

return new Profile(
    schema: __DIR__ . '/../schemas/petstore-3.0.yaml',
    output: __DIR__ . '/../generated/petstore',
    namespace: 'Mlavrinenko\\Paogen\\Tests\\Fixtures\\Generated\\Petstore',
    discoverIn: [
        'Mlavrinenko\\Paogen\\Tests\\Fixtures\\ValueObject',
    ],
);
