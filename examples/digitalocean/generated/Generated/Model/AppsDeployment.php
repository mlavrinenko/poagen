<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

use Acme\DigitalOcean\Generated\Enum\AppsDeploymentPhase;
use DateTimeImmutable;
use JsonSerializable;

final readonly class AppsDeployment implements JsonSerializable
{
    /**
     * Paogen marshal/unmarshal contract — phpName => [wireKey, shape]. See ADR-007.
     * @var array<string, array{0: string, 1: null|class-string|array{0: string, 1: null|class-string}|array{0: string, 1: list<class-string>, 2: ?string}}>
     */
    public const array PROPERTY_MAP = [
        'cause' => ['cause', null],
        'cloned_from' => ['cloned_from', null],
        'created_at' => ['created_at', ['datetime', null]],
        'functions' => ['functions', ['list', \Acme\DigitalOcean\Generated\Model\AppsDeploymentFunctions::class]],
        'id' => ['id', null],
        'jobs' => ['jobs', ['list', \Acme\DigitalOcean\Generated\Model\AppsDeploymentJob::class]],
        'phase' => ['phase', ['enum', \Acme\DigitalOcean\Generated\Enum\AppsDeploymentPhase::class]],
        'phase_last_updated_at' => ['phase_last_updated_at', ['datetime', null]],
        'progress' => ['progress', \Acme\DigitalOcean\Generated\Model\AppsDeploymentProgress::class],
        'services' => ['services', ['list', \Acme\DigitalOcean\Generated\Model\AppsDeploymentService::class]],
        'spec' => ['spec', \Acme\DigitalOcean\Generated\Model\AppSpec::class],
        'static_sites' => ['static_sites', ['list', \Acme\DigitalOcean\Generated\Model\AppsDeploymentStaticSite::class]],
        'tier_slug' => ['tier_slug', null],
        'updated_at' => ['updated_at', ['datetime', null]],
        'workers' => ['workers', ['list', \Acme\DigitalOcean\Generated\Model\AppsDeploymentWorker::class]],
    ];

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

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'cause' => $this->cause,
            'cloned_from' => $this->cloned_from,
            'created_at' => $this->created_at?->format(\DateTimeInterface::RFC3339),
            'functions' => $this->functions,
            'id' => $this->id,
            'jobs' => $this->jobs,
            'phase' => $this->phase,
            'phase_last_updated_at' => $this->phase_last_updated_at?->format(\DateTimeInterface::RFC3339),
            'progress' => $this->progress,
            'services' => $this->services,
            'spec' => $this->spec,
            'static_sites' => $this->static_sites,
            'tier_slug' => $this->tier_slug,
            'updated_at' => $this->updated_at?->format(\DateTimeInterface::RFC3339),
            'workers' => $this->workers,
        ];
    }
}
