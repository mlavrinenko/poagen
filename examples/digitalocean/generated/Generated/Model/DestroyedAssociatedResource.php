<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

use DateTimeImmutable;
use JsonSerializable;

final readonly class DestroyedAssociatedResource implements JsonSerializable
{
    /**
     * Paogen marshal/unmarshal contract — phpName => [wireKey, shape]. See ADR-007.
     * @var array<string, array{0: string, 1: null|class-string|array{0: string, 1: null|class-string}|array{0: string, 1: list<class-string>, 2: ?string}}>
     */
    public const array PROPERTY_MAP = [
        'destroyed_at' => ['destroyed_at', ['datetime', null]],
        'error_message' => ['error_message', null],
        'id' => ['id', null],
        'name' => ['name', null],
    ];

    public function __construct(
        public ?DateTimeImmutable $destroyed_at = null,
        public ?string $error_message = null,
        public ?string $id = null,
        public ?string $name = null,
    ) {
    }

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'destroyed_at' => $this->destroyed_at?->format(\DateTimeInterface::RFC3339),
            'error_message' => $this->error_message,
            'id' => $this->id,
            'name' => $this->name,
        ];
    }
}
