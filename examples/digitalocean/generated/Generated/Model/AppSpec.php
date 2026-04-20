<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

final readonly class AppSpec
{
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
}
