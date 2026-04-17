<?php

/**
 * Profile for the synthetic `contact` schema. Demonstrates BindsFormat.
 */

declare(strict_types=1);

use Mlavrinenko\Paogen\Generator\Profile;

return new Profile(
    schema: __DIR__ . '/../schemas/contact-3.0.yaml',
    output: __DIR__ . '/../generated/contact',
    namespace: 'Mlavrinenko\\Paogen\\Tests\\Fixtures\\Generated\\Contact',
    discoverIn: [
        'Mlavrinenko\\Paogen\\Tests\\Fixtures\\ValueObject',
    ],
);
