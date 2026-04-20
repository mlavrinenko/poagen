<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

final readonly class AppJobSpec
{
    /**
     * @param ?list<\Acme\DigitalOcean\Generated\Model\AppVariableDefinition> $envs
     * @param ?mixed $instance_size_slug
     * @param ?list<\Acme\DigitalOcean\Generated\Model\AppLogDestinationDefinition> $log_destinations
     */
    public function __construct(
        public string $name,
        public ?AppJobSpecAutoscaling $autoscaling = null,
        public ?AppsBitbucketSourceSpec $bitbucket = null,
        public ?string $build_command = null,
        public ?string $dockerfile_path = null,
        public ?string $environment_slug = null,
        public ?array $envs = null,
        public ?AppsGitSourceSpec $git = null,
        public ?AppsGithubSourceSpec $github = null,
        public ?AppsGitlabSourceSpec $gitlab = null,
        public ?AppsImageSourceSpec $image = null,
        public ?int $instance_count = null,
        public $instance_size_slug = null,
        public ?string $kind = null,
        public ?array $log_destinations = null,
        public ?string $run_command = null,
        public ?string $source_dir = null,
        public ?AppJobSpecTermination $termination = null,
    ) {
    }
}
