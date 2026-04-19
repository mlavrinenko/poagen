<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

use DateTimeImmutable;
use JsonSerializable;

final readonly class NetworkConfiguration implements JsonSerializable
{
    /**
     * Paogen marshal/unmarshal contract — phpName => [wireKey, shape]. See ADR-007.
     * @var array<string, array{0: string, 1: null|class-string|array{0: string, 1: null|class-string}|array{0: string, 1: list<class-string>, 2: ?string}}>
     */
    public const array PROPERTY_MAP = [
        'created_on' => ['created_on', ['datetime', null]],
        'id' => ['id', null],
        'name' => ['name', null],
        'compute_service' => ['compute_service', null],
        'failover_network_enabled' => ['failover_network_enabled', null],
        'failover_network_settings_ids' => ['failover_network_settings_ids', ['list', null]],
        'network_settings_ids' => ['network_settings_ids', ['list', null]],
    ];

    /**
     * @param ?list<string> $failover_network_settings_ids
     * @param ?list<string> $network_settings_ids
     */
    public function __construct(
        public ?DateTimeImmutable $created_on = null,
        public string $id,
        public string $name,
        public ?string $compute_service = null,
        public ?bool $failover_network_enabled = null,
        public ?array $failover_network_settings_ids = null,
        public ?array $network_settings_ids = null,
    ) {
    }

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'created_on' => $this->created_on?->format(\DateTimeInterface::RFC3339),
            'id' => $this->id,
            'name' => $this->name,
            'compute_service' => $this->compute_service,
            'failover_network_enabled' => $this->failover_network_enabled,
            'failover_network_settings_ids' => $this->failover_network_settings_ids,
            'network_settings_ids' => $this->network_settings_ids,
        ];
    }
}
