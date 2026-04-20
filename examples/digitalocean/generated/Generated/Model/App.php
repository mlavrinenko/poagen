<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

use DateTimeImmutable;

final readonly class App
{
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
}
