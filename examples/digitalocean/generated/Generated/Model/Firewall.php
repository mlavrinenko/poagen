<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

use DateTimeImmutable;

final readonly class Firewall
{
    /**
     * @param ?list<int> $droplet_ids
     * @param ?list<mixed> $inbound_rules
     * @param ?list<mixed> $outbound_rules
     * @param ?list<array<string, mixed>> $pending_changes
     * @param ?mixed $tags
     */
    public function __construct(
        public ?DateTimeImmutable $created_at = null,
        public ?array $droplet_ids = null,
        public ?string $id = null,
        public ?array $inbound_rules = null,
        public ?string $name = null,
        public ?array $outbound_rules = null,
        public ?array $pending_changes = null,
        public ?string $status = null,
        public $tags = null,
    ) {
    }
}
