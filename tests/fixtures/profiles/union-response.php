<?php

/**
 * Profile for the union-response fixture
 * (a-union-response-selects-its-branch). Exercises the response position's
 * three reachable layers in one tree — a document discriminator with an
 * explicit mapping, a structural object union, a structural array-of-items
 * union — plus a pin for the one branch set no rule can decide.
 */

declare(strict_types=1);

use Mlavrinenko\Paogen\Generator\Profile;

// See scratch-output.php: a test run never writes into the committed golden
// tree — that only happens via `just regenerate-fixture union-response`.
require_once __DIR__ . '/scratch-output.php';

return new Profile(
    schema: __DIR__ . '/../schemas/union-response-3.0.yaml',
    output: paogen_fixture_scratch_output('union-response'),
    namespace: 'Mlavrinenko\\Paogen\\Tests\\Fixtures\\Generated\\UnionResponse',
    unionPins: [
        // Celsius and Fahrenheit declare the same single optional field and
        // require nothing, so no payload could ever name one.
        'getUndecidableCreature.response' => [
            'branch' => 'Celsius',
            'reason' => 'Celsius and Fahrenheit are identical field for field and neither requires anything, so '
                . 'no payload distinguishes them; this client reads metric sensors',
        ],
    ],
);
