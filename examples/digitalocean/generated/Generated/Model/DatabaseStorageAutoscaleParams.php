<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

use JsonSerializable;

final readonly class DatabaseStorageAutoscaleParams implements JsonSerializable
{
    /**
     * Paogen marshal/unmarshal contract — phpName => [wireKey, shape]. See ADR-007.
     * @var array<string, array{0: string, 1: null|class-string|array{0: string, 1: null|class-string}|array{0: string, 1: list<class-string>, 2: ?string}}>
     */
    public const array PROPERTY_MAP = [
        'enabled' => ['enabled', null],
        'increment_gib' => ['increment_gib', null],
        'threshold_percent' => ['threshold_percent', null],
    ];

    public function __construct(
        public bool $enabled,
        public ?int $increment_gib = null,
        public ?int $threshold_percent = null,
    ) {
    }

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'enabled' => $this->enabled,
            'increment_gib' => $this->increment_gib,
            'threshold_percent' => $this->threshold_percent,
        ];
    }
}
