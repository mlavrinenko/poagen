<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

use Acme\DigitalOcean\Generated\Enum\AppsDeploymentPhase;
use DateTimeImmutable;

final readonly class AppsDeployment
{
    /**
     * @param ?list<\Acme\DigitalOcean\Generated\Model\AppsDeploymentFunctions> $functions
     * @param ?list<\Acme\DigitalOcean\Generated\Model\AppsDeploymentJob> $jobs
     * @param ?list<\Acme\DigitalOcean\Generated\Model\AppsDeploymentService> $services
     * @param ?list<\Acme\DigitalOcean\Generated\Model\AppsDeploymentStaticSite> $static_sites
     * @param ?list<\Acme\DigitalOcean\Generated\Model\AppsDeploymentWorker> $workers
     */
    public function __construct(
        public ?string $cause = null,
        public ?string $cloned_from = null,
        public ?DateTimeImmutable $created_at = null,
        public ?array $functions = null,
        public ?string $id = null,
        public ?array $jobs = null,
        public ?AppsDeploymentPhase $phase = null,
        public ?DateTimeImmutable $phase_last_updated_at = null,
        public ?AppsDeploymentProgress $progress = null,
        public ?array $services = null,
        public ?AppSpec $spec = null,
        public ?array $static_sites = null,
        public ?string $tier_slug = null,
        public ?DateTimeImmutable $updated_at = null,
        public ?array $workers = null,
    ) {
    }
}
