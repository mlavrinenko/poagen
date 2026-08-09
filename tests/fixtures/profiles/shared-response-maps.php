<?php

/**
 * Profile for the shared-response-maps fixture
 * (opt-in-collapse-for-repeated-response-maps).
 *
 * `deleteInvoice`, `voidInvoice` and `deleteCustomer` declare the same
 * response map, and this profile says they mean the same thing — one shared
 * declaration, emitted once on `Generated\ResponseMaps` and called from both
 * sub-clients. `getCustomer` shares two of the three statuses and is not
 * named, so it keeps its own literal: what is shared is stated here, never
 * inferred from the shapes lining up.
 */

declare(strict_types=1);

use Poagen\Generator\Generator\Profile;

// See scratch-output.php: a test run never writes into the committed golden
// tree — that only happens via `just regenerate-fixture shared-response-maps`.
require_once __DIR__ . '/scratch-output.php';

return new Profile(
    schema: __DIR__ . '/../schemas/shared-response-maps-3.0.yaml',
    output: poagen_fixture_scratch_output('shared-response-maps'),
    namespace: 'Poagen\\Generator\\Tests\\Fixtures\\Generated\\SharedResponseMaps',
    responseMaps: [
        'gatewayMutation' => ['deleteInvoice', 'voidInvoice', 'deleteCustomer'],
    ],
);
