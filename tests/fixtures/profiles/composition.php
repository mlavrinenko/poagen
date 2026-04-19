<?php

/**
 * Profile for the synthetic `composition` schema. Exercises oneOf / anyOf /
 * allOf codegen (T-008).
 */

declare(strict_types=1);

use Mlavrinenko\Paogen\Generator\Profile;

return new Profile(
    schema: __DIR__ . '/../schemas/composition-3.0.yaml',
    output: __DIR__ . '/../generated/composition',
    namespace: 'Mlavrinenko\\Paogen\\Tests\\Fixtures\\Generated\\Composition',
    discoverIn: [
        'Mlavrinenko\\Paogen\\Tests\\Fixtures\\ValueObject',
    ],
);
