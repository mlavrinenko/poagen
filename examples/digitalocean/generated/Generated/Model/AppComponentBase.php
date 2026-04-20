<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

final readonly class AppComponentBase
{
    /**
     * @param ?list<\Acme\DigitalOcean\Generated\Model\AppVariableDefinition> $envs
     * @param ?list<\Acme\DigitalOcean\Generated\Model\AppLogDestinationDefinition> $log_destinations
     */
    public function __construct(
        public ?AppsBitbucketSourceSpec $bitbucket = null,
        public ?string $build_command = null,
        public ?string $dockerfile_path = null,
        public ?string $environment_slug = null,
        public ?array $envs = null,
        public ?AppsGitSourceSpec $git = null,
        public ?AppsGithubSourceSpec $github = null,
        public ?AppsGitlabSourceSpec $gitlab = null,
        public ?AppsImageSourceSpec $image = null,
        public ?array $log_destinations = null,
        public ?string $name = null,
        public ?string $run_command = null,
        public ?string $source_dir = null,
    ) {
    }
}
