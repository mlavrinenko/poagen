<?php

/**
 * Profile for the T-030 override-resolves fixture. The `discriminators`
 * entry names the wire field (`petType`) for the otherwise-undiscriminated
 * `Pet.kind` oneOf.
 */

declare(strict_types=1);

use Mlavrinenko\Paogen\Generator\Profile;

return new Profile(
    schema: __DIR__ . '/../schemas/undiscriminated-oneof-3.0.yaml',
    output: __DIR__ . '/../generated/undiscriminated-oneof-resolved',
    namespace: 'Mlavrinenko\\Paogen\\Tests\\Fixtures\\Generated\\UndiscriminatedOneofResolved',
    discriminators: [
        'Pet.kind' => 'petType',
    ],
);
