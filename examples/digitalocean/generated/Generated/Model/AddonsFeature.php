<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

use DateTimeImmutable;
use JsonSerializable;

final readonly class AddonsFeature implements JsonSerializable
{
    /**
     * Paogen marshal/unmarshal contract — phpName => [wireKey, shape]. See ADR-007.
     * @var array<string, array{0: string, 1: null|class-string|array{0: string, 1: null|class-string}|array{0: string, 1: list<class-string>, 2: ?string}}>
     */
    public const array PROPERTY_MAP = [
        'created_at' => ['created_at', ['datetime', null]],
        'id' => ['id', null],
        'name' => ['name', null],
        'type' => ['type', null],
        'updated_at' => ['updated_at', ['datetime', null]],
        'value' => ['value', null],
        'unit' => ['unit', null],
    ];

    /**
     * @param mixed $value
     */
    public function __construct(
        public DateTimeImmutable $created_at,
        public int $id,
        public string $name,
        public string $type,
        public DateTimeImmutable $updated_at,
        public $value,
        public ?string $unit = null,
    ) {
    }

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'created_at' => $this->created_at->format(\DateTimeInterface::RFC3339),
            'id' => $this->id,
            'name' => $this->name,
            'type' => $this->type,
            'updated_at' => $this->updated_at->format(\DateTimeInterface::RFC3339),
            'value' => $this->value,
            'unit' => $this->unit,
        ];
    }
}
