<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

final readonly class AppFunctionsSpec
{
    /**
     * @param ?list<\Acme\DigitalOcean\Generated\Model\AppAlertSpec> $alerts
     * @param ?mixed $cors
     * @param ?list<\Acme\DigitalOcean\Generated\Model\AppVariableDefinition> $envs
     * @param ?list<\Acme\DigitalOcean\Generated\Model\AppLogDestinationDefinition> $log_destinations
     * @param ?list<\Acme\DigitalOcean\Generated\Model\AppRouteSpec> $routes
     */
    public function __construct(
        public string $name,
        public ?array $alerts = null,
        public ?AppsBitbucketSourceSpec $bitbucket = null,
        public $cors = null,
        public ?array $envs = null,
        public ?AppsGitSourceSpec $git = null,
        public ?AppsGithubSourceSpec $github = null,
        public ?AppsGitlabSourceSpec $gitlab = null,
        public ?array $log_destinations = null,
        public ?array $routes = null,
        public ?string $source_dir = null,
    ) {
    }
}
