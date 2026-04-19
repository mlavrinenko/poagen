<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

use DateTimeImmutable;
use JsonSerializable;

final readonly class Resource implements JsonSerializable
{
    /**
     * Paogen marshal/unmarshal contract — phpName => [wireKey, shape]. See ADR-007.
     * @var array<string, array{0: string, 1: null|class-string|array{0: string, 1: null|class-string}|array{0: string, 1: list<class-string>, 2: ?string}}>
     */
    public const array PROPERTY_MAP = [
        'assigned_at' => ['assigned_at', ['datetime', null]],
        'links' => ['links', \Acme\DigitalOcean\Generated\Model\ResourceLinks::class],
        'status' => ['status', null],
        'urn' => ['urn', \Acme\DigitalOcean\Generated\Model\Urn::class],
    ];

    public function __construct(
        public ?DateTimeImmutable $assigned_at = null,
        public ?ResourceLinks $links = null,
        public ?string $status = null,
        public ?Urn $urn = null,
    ) {
    }

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'assigned_at' => $this->assigned_at?->format(\DateTimeInterface::RFC3339),
            'links' => $this->links,
            'status' => $this->status,
            'urn' => $this->urn,
        ];
    }
}
