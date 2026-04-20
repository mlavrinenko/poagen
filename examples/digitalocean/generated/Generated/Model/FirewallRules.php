<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

final readonly class FirewallRules
{
    /**
     * @param ?list<mixed> $inbound_rules
     * @param ?list<mixed> $outbound_rules
     */
    public function __construct(
        public ?array $inbound_rules = null,
        public ?array $outbound_rules = null,
    ) {
    }
}
