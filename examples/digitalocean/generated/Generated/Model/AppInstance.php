<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

use JsonSerializable;

final readonly class AppInstance implements JsonSerializable
{
    /**
     * Paogen marshal/unmarshal contract — phpName => [wireKey, shape]. See ADR-007.
     * @var array<string, array{0: string, 1: null|class-string|array{0: string, 1: null|class-string}|array{0: string, 1: list<class-string>, 2: ?string}}>
     */
    public const array PROPERTY_MAP = [
        'component_name' => ['component_name', null],
        'component_type' => ['component_type', null],
        'instance_alias' => ['instance_alias', null],
        'instance_name' => ['instance_name', null],
    ];

    public function __construct(
        public ?string $component_name = null,
        public ?string $component_type = null,
        public ?string $instance_alias = null,
        public ?string $instance_name = null,
    ) {
    }

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'component_name' => $this->component_name,
            'component_type' => $this->component_type,
            'instance_alias' => $this->instance_alias,
            'instance_name' => $this->instance_name,
        ];
    }
}
