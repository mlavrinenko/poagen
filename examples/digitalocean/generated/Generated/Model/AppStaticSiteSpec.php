<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

final readonly class AppStaticSiteSpec
{
    /**
     * @param ?mixed $cors
     * @param ?list<\Acme\DigitalOcean\Generated\Model\AppVariableDefinition> $envs
     * @param ?list<\Acme\DigitalOcean\Generated\Model\AppLogDestinationDefinition> $log_destinations
     * @param ?list<\Acme\DigitalOcean\Generated\Model\AppRouteSpec> $routes
     */
    public function __construct(
        public ?AppsBitbucketSourceSpec $bitbucket = null,
        public ?string $build_command = null,
        public ?string $catchall_document = null,
        public $cors = null,
        public ?string $dockerfile_path = null,
        public ?string $environment_slug = null,
        public ?array $envs = null,
        public ?string $error_document = null,
        public ?AppsGitSourceSpec $git = null,
        public ?AppsGithubSourceSpec $github = null,
        public ?AppsGitlabSourceSpec $gitlab = null,
        public ?AppsImageSourceSpec $image = null,
        public ?string $index_document = null,
        public ?array $log_destinations = null,
        public ?string $name = null,
        public ?string $output_dir = null,
        public ?array $routes = null,
        public ?string $run_command = null,
        public ?string $source_dir = null,
    ) {
    }
}
