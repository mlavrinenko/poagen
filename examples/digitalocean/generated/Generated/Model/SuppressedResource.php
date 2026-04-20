<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

final readonly class SuppressedResource
{
    public function __construct(
        public ?string $id = null,
        public ?string $resource_id = null,
        public ?string $resource_type = null,
        public ?string $rule_name = null,
        public ?string $rule_uuid = null,
    ) {
    }
}
