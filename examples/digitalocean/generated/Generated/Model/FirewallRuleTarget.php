<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

final readonly class FirewallRuleTarget
{
    /**
     * @param ?list<string> $addresses
     * @param ?list<int> $droplet_ids
     * @param ?list<string> $kubernetes_ids
     * @param ?list<string> $load_balancer_uids
     * @param ?mixed $tags
     */
    public function __construct(
        public ?array $addresses = null,
        public ?array $droplet_ids = null,
        public ?array $kubernetes_ids = null,
        public ?array $load_balancer_uids = null,
        public $tags = null,
    ) {
    }
}
