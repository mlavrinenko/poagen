<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

use DateTimeImmutable;

final readonly class NetworkConfiguration
{
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
}
