<?php

declare(strict_types=1);

use Mlavrinenko\Paogen\Generator\Profile;

return new Profile(
    schema: __DIR__ . '/schemas/petstore-3.0.yaml',
    output: __DIR__ . '/generated',
    namespace: 'Acme\\Petstore',
    skip: [
        // multipart/octet-stream request bodies are unrepresentable —
        // paogen emits JSON and form-urlencoded bodies only. See
        // abort-on-unrepresentable-constructs.
        'uploadFile' => 'application/octet-stream request body — paogen does not support binary bodies',
    ],
    securitySchemes: [
        // The document requires `api_key` on getPetById and getInventory but
        // declares only `petstore_auth` under components.securitySchemes, so
        // the requirement names a credential nothing describes. paogen
        // refuses to guess a header name — a wrong guess is a 401 you debug
        // at runtime — and aborts naming this key. Swagger's own petstore
        // sends the key as the `api_key` request header, so that is what
        // goes here, and the two operations authenticate instead of being
        // skipped.
        'api_key' => ['type' => 'apiKey', 'in' => 'header', 'name' => 'api_key'],
    ],
);
