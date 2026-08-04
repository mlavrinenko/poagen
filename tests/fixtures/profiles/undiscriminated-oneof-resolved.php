<?php

/**
 * Profile for the T-030 override-resolves fixture. The `discriminators`
 * entry names the wire field (`petType`) for the otherwise-undiscriminated
 * `Pet.kind` oneOf.
 */

declare(strict_types=1);

use Poagen\Generator\Generator\Profile;

// See scratch-output.php: a test run never writes into the committed
// golden tree — that only happens via `just regenerate-fixture
// undiscriminated-oneof-resolved`.
require_once __DIR__ . '/scratch-output.php';

return new Profile(
    schema: __DIR__ . '/../schemas/undiscriminated-oneof-3.0.yaml',
    output: poagen_fixture_scratch_output('undiscriminated-oneof-resolved'),
    namespace: 'Poagen\\Generator\\Tests\\Fixtures\\Generated\\UndiscriminatedOneofResolved',
    discriminators: [
        'Pet.kind' => 'petType',
    ],
);
