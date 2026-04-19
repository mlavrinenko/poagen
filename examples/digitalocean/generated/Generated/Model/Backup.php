<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

use DateTimeImmutable;
use JsonSerializable;

final readonly class Backup implements JsonSerializable
{
    /**
     * Paogen marshal/unmarshal contract — phpName => [wireKey, shape]. See ADR-007.
     * @var array<string, array{0: string, 1: null|class-string|array{0: string, 1: null|class-string}|array{0: string, 1: list<class-string>, 2: ?string}}>
     */
    public const array PROPERTY_MAP = [
        'created_at' => ['created_at', ['datetime', null]],
        'size_gigabytes' => ['size_gigabytes', null],
        'incremental' => ['incremental', null],
    ];

    public function __construct(
        public DateTimeImmutable $created_at,
        public float $size_gigabytes,
        public ?bool $incremental = null,
    ) {
    }

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'created_at' => $this->created_at->format(\DateTimeInterface::RFC3339),
            'size_gigabytes' => $this->size_gigabytes,
            'incremental' => $this->incremental,
        ];
    }
}
