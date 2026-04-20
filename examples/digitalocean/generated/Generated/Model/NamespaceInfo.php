<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

final readonly class NamespaceInfo
{
    public function __construct(
        public ?string $api_host = null,
        public ?string $created_at = null,
        public ?string $key = null,
        public ?string $label = null,
        public ?string $namespace = null,
        public ?string $region = null,
        public ?string $updated_at = null,
        public ?string $uuid = null,
    ) {
    }
}
