<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

use JsonSerializable;

final readonly class Check implements JsonSerializable
{
    /**
     * Paogen marshal/unmarshal contract — phpName => [wireKey, shape]. See ADR-007.
     * @var array<string, array{0: string, 1: null|class-string|array{0: string, 1: null|class-string}|array{0: string, 1: list<class-string>, 2: ?string}}>
     */
    public const array PROPERTY_MAP = [
        'enabled' => ['enabled', null],
        'id' => ['id', null],
        'name' => ['name', null],
        'regions' => ['regions', ['list', null]],
        'target' => ['target', null],
        'type' => ['type', null],
    ];

    /**
     * @param ?list<string> $regions
     */
    public function __construct(
        public ?bool $enabled = null,
        public ?string $id = null,
        public ?string $name = null,
        public ?array $regions = null,
        public ?string $target = null,
        public ?string $type = null,
    ) {
    }

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'enabled' => $this->enabled,
            'id' => $this->id,
            'name' => $this->name,
            'regions' => $this->regions,
            'target' => $this->target,
            'type' => $this->type,
        ];
    }
}
