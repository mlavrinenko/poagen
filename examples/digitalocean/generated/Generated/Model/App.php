<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

use DateTimeImmutable;
use JsonSerializable;

final readonly class App implements JsonSerializable
{
    /**
     * Paogen marshal/unmarshal contract — phpName => [wireKey, shape]. See ADR-007.
     * @var array<string, array{0: string, 1: null|class-string|array{0: string, 1: null|class-string}|array{0: string, 1: list<class-string>, 2: ?string}}>
     */
    public const array PROPERTY_MAP = [
        'spec' => ['spec', \Acme\DigitalOcean\Generated\Model\AppSpec::class],
        'active_deployment' => ['active_deployment', \Acme\DigitalOcean\Generated\Model\AppsDeployment::class],
        'created_at' => ['created_at', ['datetime', null]],
        'dedicated_ips' => ['dedicated_ips', ['list', \Acme\DigitalOcean\Generated\Model\AppsDedicatedEgressIp::class]],
        'default_ingress' => ['default_ingress', null],
        'domains' => ['domains', ['list', \Acme\DigitalOcean\Generated\Model\AppsDomain::class]],
        'id' => ['id', null],
        'in_progress_deployment' => ['in_progress_deployment', \Acme\DigitalOcean\Generated\Model\AppsDeployment::class],
        'last_deployment_created_at' => ['last_deployment_created_at', ['datetime', null]],
        'live_domain' => ['live_domain', null],
        'live_url' => ['live_url', null],
        'live_url_base' => ['live_url_base', null],
        'owner_uuid' => ['owner_uuid', null],
        'pending_deployment' => ['pending_deployment', null],
        'pinned_deployment' => ['pinned_deployment', null],
        'project_id' => ['project_id', null],
        'region' => ['region', \Acme\DigitalOcean\Generated\Model\AppsRegion::class],
        'tier_slug' => ['tier_slug', null],
        'updated_at' => ['updated_at', ['datetime', null]],
        'vpc' => ['vpc', \Acme\DigitalOcean\Generated\Model\AppsVpc::class],
    ];

    /**
     * @param ?list<\Acme\DigitalOcean\Generated\Model\AppsDedicatedEgressIp> $dedicated_ips
     * @param ?list<\Acme\DigitalOcean\Generated\Model\AppsDomain> $domains
     * @param ?mixed $pending_deployment
     * @param ?mixed $pinned_deployment
     */
    public function __construct(
        public AppSpec $spec,
        public ?AppsDeployment $active_deployment = null,
        public ?DateTimeImmutable $created_at = null,
        public ?array $dedicated_ips = null,
        public ?string $default_ingress = null,
        public ?array $domains = null,
        public ?string $id = null,
        public ?AppsDeployment $in_progress_deployment = null,
        public ?DateTimeImmutable $last_deployment_created_at = null,
        public ?string $live_domain = null,
        public ?string $live_url = null,
        public ?string $live_url_base = null,
        public ?string $owner_uuid = null,
        public $pending_deployment = null,
        public $pinned_deployment = null,
        public ?string $project_id = null,
        public ?AppsRegion $region = null,
        public ?string $tier_slug = null,
        public ?DateTimeImmutable $updated_at = null,
        public ?AppsVpc $vpc = null,
    ) {
    }

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'spec' => $this->spec,
            'active_deployment' => $this->active_deployment,
            'created_at' => $this->created_at?->format(\DateTimeInterface::RFC3339),
            'dedicated_ips' => $this->dedicated_ips,
            'default_ingress' => $this->default_ingress,
            'domains' => $this->domains,
            'id' => $this->id,
            'in_progress_deployment' => $this->in_progress_deployment,
            'last_deployment_created_at' => $this->last_deployment_created_at?->format(\DateTimeInterface::RFC3339),
            'live_domain' => $this->live_domain,
            'live_url' => $this->live_url,
            'live_url_base' => $this->live_url_base,
            'owner_uuid' => $this->owner_uuid,
            'pending_deployment' => $this->pending_deployment,
            'pinned_deployment' => $this->pinned_deployment,
            'project_id' => $this->project_id,
            'region' => $this->region,
            'tier_slug' => $this->tier_slug,
            'updated_at' => $this->updated_at?->format(\DateTimeInterface::RFC3339),
            'vpc' => $this->vpc,
        ];
    }
}
