<?php

/**
 * Profile for the union-selection fixture
 * (declare-an-undiscriminated-union-as-raw-data). Exercises all four layers
 * in one tree: two structural selections (one of them using the closed-shape
 * predicate), one tag on the enclosing object, and one pin.
 */

declare(strict_types=1);

use Poagen\Generator\Generator\Profile;

// See scratch-output.php: a test run never writes into the committed golden
// tree — that only happens via `just regenerate-fixture union-selection`.
require_once __DIR__ . '/scratch-output.php';

return new Profile(
    schema: __DIR__ . '/../schemas/union-selection-3.0.yaml',
    output: poagen_fixture_scratch_output('union-selection'),
    namespace: 'Poagen\\Generator\\Tests\\Fixtures\\Generated\\UnionSelection',
    unionTags: [
        // `Habitat.species` is a sibling of the union, not a field inside it,
        // and enumerates exactly the two values these two branches need.
        'Habitat.resident' => [
            'field' => 'species',
            'map' => [
                'cat' => 'Cat',
                'dog' => 'Dog',
            ],
        ],
    ],
    unionPins: [
        // Celsius and Fahrenheit declare the same single optional field and
        // require nothing, so no payload could ever name one.
        'Reading.sample' => [
            'branch' => 'Celsius',
            'reason' => 'Celsius and Fahrenheit are identical field for field and neither requires anything, so no '
                . 'payload distinguishes them; this client reads metric sensors',
        ],
    ],
);
