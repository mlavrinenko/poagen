<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

use DateTimeImmutable;
use JsonSerializable;

final readonly class DedicatedInferenceAccessToken implements JsonSerializable
{
    /**
     * Paogen marshal/unmarshal contract — phpName => [wireKey, shape]. See ADR-007.
     * @var array<string, array{0: string, 1: null|class-string|array{0: string, 1: null|class-string}|array{0: string, 1: list<class-string>, 2: ?string}}>
     */
    public const array PROPERTY_MAP = [
        'created_at' => ['created_at', ['datetime', null]],
        'id' => ['id', null],
        'is_managed' => ['is_managed', null],
        'name' => ['name', null],
        'value' => ['value', null],
    ];

    public function __construct(
        public ?DateTimeImmutable $created_at = null,
        public ?string $id = null,
        public ?bool $is_managed = null,
        public ?string $name = null,
        public ?string $value = null,
    ) {
    }

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'created_at' => $this->created_at?->format(\DateTimeInterface::RFC3339),
            'id' => $this->id,
            'is_managed' => $this->is_managed,
            'name' => $this->name,
            'value' => $this->value,
        ];
    }
}
