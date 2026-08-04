<?php

/**
 * Sample poagen profile for the Petstore 3.0 fixture.
 */

declare(strict_types=1);

use Poagen\Generator\Generator\Profile;

// See scratch-output.php: a test run never writes into the committed
// golden tree — that only happens via `just regenerate-fixture petstore`.
require_once __DIR__ . '/scratch-output.php';

return new Profile(
    schema: __DIR__ . '/../schemas/petstore-3.0.yaml',
    output: poagen_fixture_scratch_output('petstore'),
    namespace: 'Poagen\\Generator\\Tests\\Fixtures\\Generated\\Petstore',
    discoverIn: [
        'Poagen\\Generator\\Tests\\Fixtures\\ValueObject',
    ],
    // `uploadFile` was skipped here for its `application/octet-stream` body
    // until represent-non-json-request-and-response-bodies gave that body a
    // `Psr\Http\Message\StreamInterface` parameter. Nothing in this document
    // is unrepresentable now, so there is no skip list — and leaving the
    // entry would fail the run as stale rather than pass quietly.
    securitySchemes: [
        // The document requires `api_key` on getPetById and getInventory
        // and declares only `petstore_auth`, so those two operations name a
        // credential nothing describes. The fixture is an unmodified vendor
        // document (`fixtures-are-unmodified-vendor-documents`) and poagen
        // will not guess a header name, so the declaration the document is
        // missing is supplied here instead. Swagger's own petstore sends it
        // as the `api_key` request header.
        'api_key' => ['type' => 'apiKey', 'in' => 'header', 'name' => 'api_key'],
    ],
);
