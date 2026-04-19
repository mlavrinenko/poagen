<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

use DateTimeImmutable;
use JsonSerializable;

final readonly class LoadBalancer implements JsonSerializable
{
    /**
     * Paogen marshal/unmarshal contract — phpName => [wireKey, shape]. See ADR-007.
     * @var array<string, array{0: string, 1: null|class-string|array{0: string, 1: null|class-string}|array{0: string, 1: list<class-string>, 2: ?string}}>
     */
    public const array PROPERTY_MAP = [
        'forwarding_rules' => ['forwarding_rules', ['list', \Acme\DigitalOcean\Generated\Model\ForwardingRule::class]],
        'algorithm' => ['algorithm', null],
        'created_at' => ['created_at', ['datetime', null]],
        'disable_lets_encrypt_dns_records' => ['disable_lets_encrypt_dns_records', null],
        'domains' => ['domains', ['list', \Acme\DigitalOcean\Generated\Model\Domains::class]],
        'droplet_ids' => ['droplet_ids', ['list', null]],
        'enable_backend_keepalive' => ['enable_backend_keepalive', null],
        'enable_proxy_protocol' => ['enable_proxy_protocol', null],
        'firewall' => ['firewall', \Acme\DigitalOcean\Generated\Model\LbFirewall::class],
        'glb_settings' => ['glb_settings', \Acme\DigitalOcean\Generated\Model\GlbSettings::class],
        'health_check' => ['health_check', \Acme\DigitalOcean\Generated\Model\HealthCheck::class],
        'http_idle_timeout_seconds' => ['http_idle_timeout_seconds', null],
        'id' => ['id', null],
        'ip' => ['ip', null],
        'ipv6' => ['ipv6', null],
        'name' => ['name', null],
        'network' => ['network', null],
        'network_stack' => ['network_stack', null],
        'project_id' => ['project_id', null],
        'redirect_http_to_https' => ['redirect_http_to_https', null],
        'region' => ['region', null],
        'size' => ['size', null],
        'size_unit' => ['size_unit', null],
        'status' => ['status', null],
        'sticky_sessions' => ['sticky_sessions', \Acme\DigitalOcean\Generated\Model\StickySessions::class],
        'tag' => ['tag', null],
        'target_load_balancer_ids' => ['target_load_balancer_ids', ['list', null]],
        'tls_cipher_policy' => ['tls_cipher_policy', null],
        'type' => ['type', null],
        'vpc_uuid' => ['vpc_uuid', null],
    ];

    /**
     * @param list<\Acme\DigitalOcean\Generated\Model\ForwardingRule> $forwarding_rules
     * @param ?list<\Acme\DigitalOcean\Generated\Model\Domains> $domains
     * @param ?list<int> $droplet_ids
     * @param ?array<string, mixed> $region
     * @param ?list<string> $target_load_balancer_ids
     */
    public function __construct(
        public array $forwarding_rules,
        public ?string $algorithm = null,
        public ?DateTimeImmutable $created_at = null,
        public ?bool $disable_lets_encrypt_dns_records = null,
        public ?array $domains = null,
        public ?array $droplet_ids = null,
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
        public ?array $region = null,
        public ?string $size = null,
        public ?int $size_unit = null,
        public ?string $status = null,
        public ?StickySessions $sticky_sessions = null,
        public ?string $tag = null,
        public ?array $target_load_balancer_ids = null,
        public ?string $tls_cipher_policy = null,
        public ?string $type = null,
        public ?string $vpc_uuid = null,
    ) {
    }

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'forwarding_rules' => $this->forwarding_rules,
            'algorithm' => $this->algorithm,
            'created_at' => $this->created_at?->format(\DateTimeInterface::RFC3339),
            'disable_lets_encrypt_dns_records' => $this->disable_lets_encrypt_dns_records,
            'domains' => $this->domains,
            'droplet_ids' => $this->droplet_ids,
            'enable_backend_keepalive' => $this->enable_backend_keepalive,
            'enable_proxy_protocol' => $this->enable_proxy_protocol,
            'firewall' => $this->firewall,
            'glb_settings' => $this->glb_settings,
            'health_check' => $this->health_check,
            'http_idle_timeout_seconds' => $this->http_idle_timeout_seconds,
            'id' => $this->id,
            'ip' => $this->ip,
            'ipv6' => $this->ipv6,
            'name' => $this->name,
            'network' => $this->network,
            'network_stack' => $this->network_stack,
            'project_id' => $this->project_id,
            'redirect_http_to_https' => $this->redirect_http_to_https,
            'region' => $this->region,
            'size' => $this->size,
            'size_unit' => $this->size_unit,
            'status' => $this->status,
            'sticky_sessions' => $this->sticky_sessions,
            'tag' => $this->tag,
            'target_load_balancer_ids' => $this->target_load_balancer_ids,
            'tls_cipher_policy' => $this->tls_cipher_policy,
            'type' => $this->type,
            'vpc_uuid' => $this->vpc_uuid,
        ];
    }
}
