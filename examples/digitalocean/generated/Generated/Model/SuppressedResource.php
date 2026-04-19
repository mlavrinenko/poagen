<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

use JsonSerializable;

final readonly class SuppressedResource implements JsonSerializable
{
    /**
     * Paogen marshal/unmarshal contract — phpName => [wireKey, shape]. See ADR-007.
     * @var array<string, array{0: string, 1: null|class-string|array{0: string, 1: null|class-string}|array{0: string, 1: list<class-string>, 2: ?string}}>
     */
    public const array PROPERTY_MAP = [
        'id' => ['id', null],
        'resource_id' => ['resource_id', null],
        'resource_type' => ['resource_type', null],
        'rule_name' => ['rule_name', null],
        'rule_uuid' => ['rule_uuid', null],
    ];

    public function __construct(
        public ?string $id = null,
        public ?string $resource_id = null,
        public ?string $resource_type = null,
        public ?string $rule_name = null,
        public ?string $rule_uuid = null,
    ) {
    }

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'id' => $this->id,
            'resource_id' => $this->resource_id,
            'resource_type' => $this->resource_type,
            'rule_name' => $this->rule_name,
            'rule_uuid' => $this->rule_uuid,
        ];
    }
}
