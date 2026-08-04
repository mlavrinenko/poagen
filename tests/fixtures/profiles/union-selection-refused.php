<?php

/**
 * The same union-selection fixture with no guidance at all, so `Reading.sample`
 * — whose two branches declare the same single optional field and require
 * nothing — reaches layer three and refuses. Every other union in that document
 * still resolves on its own, which is the point: the refusal is scoped to the
 * union that earned it rather than to undiscriminated unions as a category.
 *
 * Designed to abort, so it has no golden tree of its own.
 */

declare(strict_types=1);
use Poagen\Generator\Generator\Profile;

require_once __DIR__ . '/scratch-output.php';

return new Profile(
    schema: __DIR__ . '/../schemas/union-selection-3.0.yaml',
    output: poagen_fixture_scratch_output('union-selection-refused'),
    namespace: 'Poagen\\Generator\\Tests\\Fixtures\\Generated\\UnionSelectionRefused',
);
