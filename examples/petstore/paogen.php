<?php

declare(strict_types=1);

use Mlavrinenko\Paogen\Generator\Profile;

return new Profile(
    schema: __DIR__ . '/schemas/petstore-3.0.yaml',
    output: __DIR__ . '/generated',
    namespace: 'Acme\\Petstore',
    // `uploadFile` sat here until
    // `represent-non-json-request-and-response-bodies`: its
    // `application/octet-stream` body is now a `Psr\Http\Message\StreamInterface`
    // parameter the transport hands to the request unread. Nothing in this
    // document is unrepresentable any more, so there is no skip list.
);
