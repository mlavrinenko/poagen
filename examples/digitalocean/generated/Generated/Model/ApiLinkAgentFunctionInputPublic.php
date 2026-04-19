<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

use JsonSerializable;

final readonly class ApiLinkAgentFunctionInputPublic implements JsonSerializable
{
    /**
     * Paogen marshal/unmarshal contract — phpName => [wireKey, shape]. See ADR-007.
     * @var array<string, array{0: string, 1: null|class-string|array{0: string, 1: null|class-string}|array{0: string, 1: list<class-string>, 2: ?string}}>
     */
    public const array PROPERTY_MAP = [
        'agent_uuid' => ['agent_uuid', null],
        'description' => ['description', null],
        'faas_name' => ['faas_name', null],
        'faas_namespace' => ['faas_namespace', null],
        'function_name' => ['function_name', null],
        'input_schema' => ['input_schema', null],
        'output_schema' => ['output_schema', null],
    ];

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
        public ?array $input_schema = null,
        public ?array $output_schema = null,
    ) {
    }

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'agent_uuid' => $this->agent_uuid,
            'description' => $this->description,
            'faas_name' => $this->faas_name,
            'faas_namespace' => $this->faas_namespace,
            'function_name' => $this->function_name,
            'input_schema' => $this->input_schema,
            'output_schema' => $this->output_schema,
        ];
    }
}
