<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

use JsonSerializable;

final readonly class SelectiveDestroyAssociatedResource implements JsonSerializable
{
    /**
     * Paogen marshal/unmarshal contract — phpName => [wireKey, shape]. See ADR-007.
     * @var array<string, array{0: string, 1: null|class-string|array{0: string, 1: null|class-string}|array{0: string, 1: list<class-string>, 2: ?string}}>
     */
    public const array PROPERTY_MAP = [
        'floating_ips' => ['floating_ips', ['list', null]],
        'reserved_ips' => ['reserved_ips', ['list', null]],
        'snapshots' => ['snapshots', ['list', null]],
        'volume_snapshots' => ['volume_snapshots', ['list', null]],
        'volumes' => ['volumes', ['list', null]],
    ];

    /**
     * @param ?list<string> $floating_ips
     * @param ?list<string> $reserved_ips
     * @param ?list<string> $snapshots
     * @param ?list<string> $volume_snapshots
     * @param ?list<string> $volumes
     */
    public function __construct(
        public ?array $floating_ips = null,
        public ?array $reserved_ips = null,
        public ?array $snapshots = null,
        public ?array $volume_snapshots = null,
        public ?array $volumes = null,
    ) {
    }

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'floating_ips' => $this->floating_ips,
            'reserved_ips' => $this->reserved_ips,
            'snapshots' => $this->snapshots,
            'volume_snapshots' => $this->volume_snapshots,
            'volumes' => $this->volumes,
        ];
    }
}
