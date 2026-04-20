<?php

/**
 * Profile for the T-030 abort fixture. Intentionally has no
 * `discriminators` override, so the generator aborts on `Pet.kind`.
 */

declare(strict_types=1);

use Mlavrinenko\Paogen\Generator\Profile;

return new Profile(
    schema: __DIR__ . '/../schemas/undiscriminated-oneof-3.0.yaml',
    output: __DIR__ . '/../generated/undiscriminated-oneof',
    namespace: 'Mlavrinenko\\Paogen\\Tests\\Fixtures\\Generated\\UndiscriminatedOneof',
);
