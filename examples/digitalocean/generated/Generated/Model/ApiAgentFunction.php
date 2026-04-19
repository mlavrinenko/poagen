<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

use DateTimeImmutable;
use JsonSerializable;

final readonly class ApiAgentFunction implements JsonSerializable
{
    /**
     * Paogen marshal/unmarshal contract — phpName => [wireKey, shape]. See ADR-007.
     * @var array<string, array{0: string, 1: null|class-string|array{0: string, 1: null|class-string}|array{0: string, 1: list<class-string>, 2: ?string}}>
     */
    public const array PROPERTY_MAP = [
        'api_key' => ['api_key', null],
        'created_at' => ['created_at', ['datetime', null]],
        'created_by' => ['created_by', null],
        'description' => ['description', null],
        'faas_name' => ['faas_name', null],
        'faas_namespace' => ['faas_namespace', null],
        'input_schema' => ['input_schema', null],
        'name' => ['name', null],
        'output_schema' => ['output_schema', null],
        'updated_at' => ['updated_at', ['datetime', null]],
        'url' => ['url', null],
        'uuid' => ['uuid', null],
    ];

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

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'api_key' => $this->api_key,
            'created_at' => $this->created_at?->format(\DateTimeInterface::RFC3339),
            'created_by' => $this->created_by,
            'description' => $this->description,
            'faas_name' => $this->faas_name,
            'faas_namespace' => $this->faas_namespace,
            'input_schema' => $this->input_schema,
            'name' => $this->name,
            'output_schema' => $this->output_schema,
            'updated_at' => $this->updated_at?->format(\DateTimeInterface::RFC3339),
            'url' => $this->url,
            'uuid' => $this->uuid,
        ];
    }
}
