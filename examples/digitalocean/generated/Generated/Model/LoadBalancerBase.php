<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

use DateTimeImmutable;

final readonly class LoadBalancerBase
{
    /**
     * @param list<\Acme\DigitalOcean\Generated\Model\ForwardingRule> $forwarding_rules
     * @param ?list<\Acme\DigitalOcean\Generated\Model\Domains> $domains
     * @param ?list<string> $target_load_balancer_ids
     */
    public function __construct(
        public array $forwarding_rules,
        public ?string $algorithm = null,
        public ?DateTimeImmutable $created_at = null,
        public ?bool $disable_lets_encrypt_dns_records = null,
        public ?array $domains = null,
        public ?bool $enable_backend_keepalive = null,
        public ?bool $enable_proxy_protocol = null,
        public ?LbFirewall $firewall = null,
        public ?GlbSettings $glb_settings = null,
        public ?HealthCheck $health_check = null,
        public ?int $http_idle_timeout_seconds = null,
        public ?string $id = null,
        public ?string $ip = null,
        public ?string $ipv6 = null,
        public ?string $name = null,
        public ?string $network = null,
        public ?string $network_stack = null,
        public ?string $project_id = null,
        public ?bool $redirect_http_to_https = null,
        public ?string $size = null,
        public ?int $size_unit = null,
        public ?string $status = null,
        public ?StickySessions $sticky_sessions = null,
        public ?array $target_load_balancer_ids = null,
        public ?string $tls_cipher_policy = null,
        public ?string $type = null,
        public ?string $vpc_uuid = null,
    ) {
    }
}
