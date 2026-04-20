<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

final readonly class AppServiceSpec
{
    /**
     * @param ?mixed $cors
     * @param ?list<\Acme\DigitalOcean\Generated\Model\AppVariableDefinition> $envs
     * @param ?mixed $instance_size_slug
     * @param ?list<int> $internal_ports
     * @param ?list<\Acme\DigitalOcean\Generated\Model\AppLogDestinationDefinition> $log_destinations
     * @param ?list<\Acme\DigitalOcean\Generated\Model\AppRouteSpec> $routes
     */
    public function __construct(
        public string $name,
        public ?AppServiceSpecAutoscaling $autoscaling = null,
        public ?AppsBitbucketSourceSpec $bitbucket = null,
        public ?string $build_command = null,
        public $cors = null,
        public ?string $dockerfile_path = null,
        public ?string $environment_slug = null,
        public ?array $envs = null,
        public ?AppsGitSourceSpec $git = null,
        public ?AppsGithubSourceSpec $github = null,
        public ?AppsGitlabSourceSpec $gitlab = null,
        public ?AppServiceSpecHealthCheck $health_check = null,
        public ?int $http_port = null,
        public ?AppsImageSourceSpec $image = null,
        public ?int $instance_count = null,
        public $instance_size_slug = null,
        public ?array $internal_ports = null,
        public ?AppHealthCheckSpec $liveness_health_check = null,
        public ?array $log_destinations = null,
        public ?string $protocol = null,
        public ?array $routes = null,
        public ?string $run_command = null,
        public ?string $source_dir = null,
        public ?AppServiceSpecTermination $termination = null,
    ) {
    }
}
