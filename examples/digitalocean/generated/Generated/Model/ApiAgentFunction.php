<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

use DateTimeImmutable;

final readonly class ApiAgentFunction
{
    /**
     * @param ?array<string, mixed> $input_schema
     * @param ?array<string, mixed> $output_schema
     */
    public function __construct(
        public ?string $api_key = null,
        public ?DateTimeImmutable $created_at = null,
        public ?string $created_by = null,
        public ?string $description = null,
        public ?string $faas_name = null,
        public ?string $faas_namespace = null,
        public ?array $input_schema = null,
        public ?string $name = null,
        public ?array $output_schema = null,
        public ?DateTimeImmutable $updated_at = null,
        public ?string $url = null,
        public ?string $uuid = null,
    ) {
    }
}
