<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

final readonly class ApiUpdateAgentFunctionInputPublic
{
    /**
     * @param ?array<string, mixed> $input_schema
     * @param ?array<string, mixed> $output_schema
     */
    public function __construct(
        public ?string $agent_uuid = null,
        public ?string $description = null,
        public ?string $faas_name = null,
        public ?string $faas_namespace = null,
        public ?string $function_name = null,
        public ?string $function_uuid = null,
        public ?array $input_schema = null,
        public ?array $output_schema = null,
    ) {
    }
}
