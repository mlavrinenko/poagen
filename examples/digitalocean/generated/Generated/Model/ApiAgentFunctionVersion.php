<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

final readonly class ApiAgentFunctionVersion
{
    public function __construct(
        public ?string $description = null,
        public ?string $faas_name = null,
        public ?string $faas_namespace = null,
        public ?bool $is_deleted = null,
        public ?string $name = null,
    ) {
    }
}
