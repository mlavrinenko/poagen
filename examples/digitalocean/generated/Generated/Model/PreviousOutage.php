<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

use JsonSerializable;

final readonly class PreviousOutage implements JsonSerializable
{
    /**
     * Paogen marshal/unmarshal contract — phpName => [wireKey, shape]. See ADR-007.
     * @var array<string, array{0: string, 1: null|class-string|array{0: string, 1: null|class-string}|array{0: string, 1: list<class-string>, 2: ?string}}>
     */
    public const array PROPERTY_MAP = [
        'duration_seconds' => ['duration_seconds', null],
        'ended_at' => ['ended_at', null],
        'region' => ['region', null],
        'started_at' => ['started_at', null],
    ];

    public function __construct(
        public ?int $duration_seconds = null,
        public ?string $ended_at = null,
        public ?string $region = null,
        public ?string $started_at = null,
    ) {
    }

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'duration_seconds' => $this->duration_seconds,
            'ended_at' => $this->ended_at,
            'region' => $this->region,
            'started_at' => $this->started_at,
        ];
    }
}
