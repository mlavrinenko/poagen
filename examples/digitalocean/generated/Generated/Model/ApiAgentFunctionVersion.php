<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

use JsonSerializable;

final readonly class ApiAgentFunctionVersion implements JsonSerializable
{
    /**
     * Paogen marshal/unmarshal contract — phpName => [wireKey, shape]. See ADR-007.
     * @var array<string, array{0: string, 1: null|class-string|array{0: string, 1: null|class-string}|array{0: string, 1: list<class-string>, 2: ?string}}>
     */
    public const array PROPERTY_MAP = [
        'description' => ['description', null],
        'faas_name' => ['faas_name', null],
        'faas_namespace' => ['faas_namespace', null],
        'is_deleted' => ['is_deleted', null],
        'name' => ['name', null],
    ];

    public function __construct(
        public ?string $description = null,
        public ?string $faas_name = null,
        public ?string $faas_namespace = null,
        public ?bool $is_deleted = null,
        public ?string $name = null,
    ) {
    }

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'description' => $this->description,
            'faas_name' => $this->faas_name,
            'faas_namespace' => $this->faas_namespace,
            'is_deleted' => $this->is_deleted,
            'name' => $this->name,
        ];
    }
}
