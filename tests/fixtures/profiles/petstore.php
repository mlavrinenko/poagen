<?php

/**
 * Sample paogen profile for the Petstore 3.0 fixture.
 */

declare(strict_types=1);

use Mlavrinenko\Paogen\Generator\Profile;

// See scratch-output.php: a test run never writes into the committed
// golden tree — that only happens via `just regenerate-fixture petstore`.
require_once __DIR__ . '/scratch-output.php';

return new Profile(
    schema: __DIR__ . '/../schemas/petstore-3.0.yaml',
    output: paogen_fixture_scratch_output('petstore'),
    namespace: 'Mlavrinenko\\Paogen\\Tests\\Fixtures\\Generated\\Petstore',
    discoverIn: [
        'Mlavrinenko\\Paogen\\Tests\\Fixtures\\ValueObject',
    ],
    skip: [
        // multipart/octet-stream request bodies are unrepresentable —
        // paogen emits JSON and form-urlencoded bodies only. See
        // abort-on-unrepresentable-constructs.
        'uploadFile' => 'application/octet-stream request body — paogen does not support binary bodies',
    ],
    securitySchemes: [
        // The document requires `api_key` on getPetById and getInventory
        // and declares only `petstore_auth`, so those two operations name a
        // credential nothing describes. The fixture is an unmodified vendor
        // document (`fixtures-are-unmodified-vendor-documents`) and paogen
        // will not guess a header name, so the declaration the document is
        // missing is supplied here instead. Swagger's own petstore sends it
        // as the `api_key` request header.
        'api_key' => ['type' => 'apiKey', 'in' => 'header', 'name' => 'api_key'],
    ],
);
