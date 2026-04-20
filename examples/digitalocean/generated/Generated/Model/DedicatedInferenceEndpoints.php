<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

final readonly class DedicatedInferenceEndpoints
{
    public function __construct(
        public ?string $private_endpoint_fqdn = null,
        public ?string $public_endpoint_fqdn = null,
    ) {
    }
}
