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
);
