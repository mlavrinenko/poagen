<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

use JsonSerializable;

final readonly class AddonsAppMetadata implements JsonSerializable
{
    /**
     * Paogen marshal/unmarshal contract — phpName => [wireKey, shape]. See ADR-007.
     * @var array<string, array{0: string, 1: null|class-string|array{0: string, 1: null|class-string}|array{0: string, 1: list<class-string>, 2: ?string}}>
     */
    public const array PROPERTY_MAP = [
        'description' => ['description', null],
        'display_name' => ['display_name', null],
        'id' => ['id', null],
        'name' => ['name', null],
        'type' => ['type', null],
        'options' => ['options', ['list', null]],
    ];

    /**
     * @param ?list<string> $options
     */
    public function __construct(
        public string $description,
        public string $display_name,
        public int $id,
        public string $name,
        public string $type,
        public ?array $options = null,
    ) {
    }

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'description' => $this->description,
            'display_name' => $this->display_name,
            'id' => $this->id,
            'name' => $this->name,
            'type' => $this->type,
            'options' => $this->options,
        ];
    }
}
