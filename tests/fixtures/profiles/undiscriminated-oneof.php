<?php

/**
 * Profile for the T-030 abort fixture. Intentionally has no
 * `discriminators` override, so the generator aborts on `Pet.kind`.
 */

declare(strict_types=1);

use Mlavrinenko\Paogen\Generator\Profile;

// See scratch-output.php. This profile is designed to abort (no
// `discriminators` override), so it has no golden tree of its own — kept
// consistent with the rest of this directory anyway.
require_once __DIR__ . '/scratch-output.php';

return new Profile(
    schema: __DIR__ . '/../schemas/undiscriminated-oneof-3.0.yaml',
    output: paogen_fixture_scratch_output('undiscriminated-oneof'),
    namespace: 'Mlavrinenko\\Paogen\\Tests\\Fixtures\\Generated\\UndiscriminatedOneof',
);
