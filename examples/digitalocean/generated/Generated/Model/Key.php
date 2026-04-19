<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

use DateTimeImmutable;
use JsonSerializable;

final readonly class Key implements JsonSerializable
{
    /**
     * Paogen marshal/unmarshal contract — phpName => [wireKey, shape]. See ADR-007.
     * @var array<string, array{0: string, 1: null|class-string|array{0: string, 1: null|class-string}|array{0: string, 1: list<class-string>, 2: ?string}}>
     */
    public const array PROPERTY_MAP = [
        'access_key' => ['access_key', null],
        'created_at' => ['created_at', ['datetime', null]],
        'grants' => ['grants', ['list', \Acme\DigitalOcean\Generated\Model\Grant::class]],
        'name' => ['name', null],
    ];

    /**
     * @param ?list<\Acme\DigitalOcean\Generated\Model\Grant> $grants
     */
    public function __construct(
        public ?string $access_key = null,
        public ?DateTimeImmutable $created_at = null,
        public ?array $grants = null,
        public ?string $name = null,
    ) {
    }

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'access_key' => $this->access_key,
            'created_at' => $this->created_at?->format(\DateTimeInterface::RFC3339),
            'grants' => $this->grants,
            'name' => $this->name,
        ];
    }
}
