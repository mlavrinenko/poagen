<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

final readonly class DestinationOmitCredentials
{
    public function __construct(
        public ?OpensearchConfigOmitCredentials $config = null,
        public ?string $id = null,
        public ?string $name = null,
        public ?string $type = null,
    ) {
    }
}
