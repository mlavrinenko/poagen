<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

use DateTimeImmutable;
use JsonSerializable;

final readonly class DropletNextBackupWindow implements JsonSerializable
{
    /**
     * Paogen marshal/unmarshal contract — phpName => [wireKey, shape]. See ADR-007.
     * @var array<string, array{0: string, 1: null|class-string|array{0: string, 1: null|class-string}|array{0: string, 1: list<class-string>, 2: ?string}}>
     */
    public const array PROPERTY_MAP = ['end' => ['end', ['datetime', null]], 'start' => ['start', ['datetime', null]]];

    public function __construct(
        public ?DateTimeImmutable $end = null,
        public ?DateTimeImmutable $start = null,
    ) {
    }

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'end' => $this->end?->format(\DateTimeInterface::RFC3339),
            'start' => $this->start?->format(\DateTimeInterface::RFC3339),
        ];
    }
}
