<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

use JsonSerializable;

final readonly class AppSpec implements JsonSerializable
{
    /**
     * Paogen marshal/unmarshal contract — phpName => [wireKey, shape]. See ADR-007.
     * @var array<string, array{0: string, 1: null|class-string|array{0: string, 1: null|class-string}|array{0: string, 1: list<class-string>, 2: ?string}}>
     */
    public const array PROPERTY_MAP = [
        'name' => ['name', null],
        'databases' => ['databases', ['list', \Acme\DigitalOcean\Generated\Model\AppDatabaseSpec::class]],
        'disable_edge_cache' => ['disable_edge_cache', null],
        'disable_email_obfuscation' => ['disable_email_obfuscation', null],
        'domains' => ['domains', ['list', \Acme\DigitalOcean\Generated\Model\AppDomainSpec::class]],
        'egress' => ['egress', \Acme\DigitalOcean\Generated\Model\AppEgressSpec::class],
        'enhanced_threat_control_enabled' => ['enhanced_threat_control_enabled', null],
        'functions' => ['functions', ['list', \Acme\DigitalOcean\Generated\Model\AppFunctionsSpec::class]],
        'ingress' => ['ingress', \Acme\DigitalOcean\Generated\Model\AppIngressSpec::class],
        'jobs' => ['jobs', ['list', \Acme\DigitalOcean\Generated\Model\AppJobSpec::class]],
        'maintenance' => ['maintenance', \Acme\DigitalOcean\Generated\Model\AppMaintenanceSpec::class],
        'region' => ['region', null],
        'services' => ['services', ['list', \Acme\DigitalOcean\Generated\Model\AppServiceSpec::class]],
        'static_sites' => ['static_sites', ['list', \Acme\DigitalOcean\Generated\Model\AppStaticSiteSpec::class]],
        'vpc' => ['vpc', \Acme\DigitalOcean\Generated\Model\AppsVpc::class],
        'workers' => ['workers', ['list', \Acme\DigitalOcean\Generated\Model\AppWorkerSpec::class]],
    ];

    /**
     * @param ?list<\Acme\DigitalOcean\Generated\Model\AppDatabaseSpec> $databases
     * @param ?list<\Acme\DigitalOcean\Generated\Model\AppDomainSpec> $domains
     * @param ?list<\Acme\DigitalOcean\Generated\Model\AppFunctionsSpec> $functions
     * @param ?list<\Acme\DigitalOcean\Generated\Model\AppJobSpec> $jobs
     * @param ?list<\Acme\DigitalOcean\Generated\Model\AppServiceSpec> $services
     * @param ?list<\Acme\DigitalOcean\Generated\Model\AppStaticSiteSpec> $static_sites
     * @param ?list<\Acme\DigitalOcean\Generated\Model\AppWorkerSpec> $workers
     */
    public function __construct(
        public string $name,
        public ?array $databases = null,
        public ?bool $disable_edge_cache = null,
        public ?bool $disable_email_obfuscation = null,
        public ?array $domains = null,
        public ?AppEgressSpec $egress = null,
        public ?bool $enhanced_threat_control_enabled = null,
        public ?array $functions = null,
        public ?AppIngressSpec $ingress = null,
        public ?array $jobs = null,
        public ?AppMaintenanceSpec $maintenance = null,
        public ?string $region = null,
        public ?array $services = null,
        public ?array $static_sites = null,
        public ?AppsVpc $vpc = null,
        public ?array $workers = null,
    ) {
    }

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'name' => $this->name,
            'databases' => $this->databases,
            'disable_edge_cache' => $this->disable_edge_cache,
            'disable_email_obfuscation' => $this->disable_email_obfuscation,
            'domains' => $this->domains,
            'egress' => $this->egress,
            'enhanced_threat_control_enabled' => $this->enhanced_threat_control_enabled,
            'functions' => $this->functions,
            'ingress' => $this->ingress,
            'jobs' => $this->jobs,
            'maintenance' => $this->maintenance,
            'region' => $this->region,
            'services' => $this->services,
            'static_sites' => $this->static_sites,
            'vpc' => $this->vpc,
            'workers' => $this->workers,
        ];
    }
}
