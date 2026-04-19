<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

use JsonSerializable;

final readonly class DestroyAssociatedKubernetesResources implements JsonSerializable
{
    /**
     * Paogen marshal/unmarshal contract — phpName => [wireKey, shape]. See ADR-007.
     * @var array<string, array{0: string, 1: null|class-string|array{0: string, 1: null|class-string}|array{0: string, 1: list<class-string>, 2: ?string}}>
     */
    public const array PROPERTY_MAP = [
        'load_balancers' => ['load_balancers', ['list', null]],
        'volume_snapshots' => ['volume_snapshots', ['list', null]],
        'volumes' => ['volumes', ['list', null]],
    ];

    /**
     * @param ?list<string> $load_balancers
     * @param ?list<string> $volume_snapshots
     * @param ?list<string> $volumes
     */
    public function __construct(
        public ?array $load_balancers = null,
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
            'load_balancers' => $this->load_balancers,
            'volume_snapshots' => $this->volume_snapshots,
            'volumes' => $this->volumes,
        ];
    }
}
