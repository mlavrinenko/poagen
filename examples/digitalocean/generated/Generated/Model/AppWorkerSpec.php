<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

use JsonSerializable;

final readonly class AppWorkerSpec implements JsonSerializable
{
    /**
     * Paogen marshal/unmarshal contract — phpName => [wireKey, shape]. See ADR-007.
     * @var array<string, array{0: string, 1: null|class-string|array{0: string, 1: null|class-string}|array{0: string, 1: list<class-string>, 2: ?string}}>
     */
    public const array PROPERTY_MAP = [
        'autoscaling' => ['autoscaling', \Acme\DigitalOcean\Generated\Model\AppWorkerSpecAutoscaling::class],
        'bitbucket' => ['bitbucket', \Acme\DigitalOcean\Generated\Model\AppsBitbucketSourceSpec::class],
        'build_command' => ['build_command', null],
        'dockerfile_path' => ['dockerfile_path', null],
        'environment_slug' => ['environment_slug', null],
        'envs' => ['envs', ['list', \Acme\DigitalOcean\Generated\Model\AppVariableDefinition::class]],
        'git' => ['git', \Acme\DigitalOcean\Generated\Model\AppsGitSourceSpec::class],
        'github' => ['github', \Acme\DigitalOcean\Generated\Model\AppsGithubSourceSpec::class],
        'gitlab' => ['gitlab', \Acme\DigitalOcean\Generated\Model\AppsGitlabSourceSpec::class],
        'image' => ['image', \Acme\DigitalOcean\Generated\Model\AppsImageSourceSpec::class],
        'instance_count' => ['instance_count', null],
        'instance_size_slug' => ['instance_size_slug', null],
        'liveness_health_check' => ['liveness_health_check', \Acme\DigitalOcean\Generated\Model\AppHealthCheckSpec::class],
        'log_destinations' => [
            'log_destinations',
            ['list', \Acme\DigitalOcean\Generated\Model\AppLogDestinationDefinition::class],
        ],
        'name' => ['name', null],
        'run_command' => ['run_command', null],
        'source_dir' => ['source_dir', null],
        'termination' => ['termination', \Acme\DigitalOcean\Generated\Model\AppWorkerSpecTermination::class],
    ];

    /**
     * @param ?list<\Acme\DigitalOcean\Generated\Model\AppVariableDefinition> $envs
     * @param ?mixed $instance_size_slug
     * @param ?list<\Acme\DigitalOcean\Generated\Model\AppLogDestinationDefinition> $log_destinations
     */
    public function __construct(
        public ?AppWorkerSpecAutoscaling $autoscaling = null,
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
        public ?AppHealthCheckSpec $liveness_health_check = null,
        public ?array $log_destinations = null,
        public ?string $name = null,
        public ?string $run_command = null,
        public ?string $source_dir = null,
        public ?AppWorkerSpecTermination $termination = null,
    ) {
    }

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'autoscaling' => $this->autoscaling,
            'bitbucket' => $this->bitbucket,
            'build_command' => $this->build_command,
            'dockerfile_path' => $this->dockerfile_path,
            'environment_slug' => $this->environment_slug,
            'envs' => $this->envs,
            'git' => $this->git,
            'github' => $this->github,
            'gitlab' => $this->gitlab,
            'image' => $this->image,
            'instance_count' => $this->instance_count,
            'instance_size_slug' => $this->instance_size_slug,
            'liveness_health_check' => $this->liveness_health_check,
            'log_destinations' => $this->log_destinations,
            'name' => $this->name,
            'run_command' => $this->run_command,
            'source_dir' => $this->source_dir,
            'termination' => $this->termination,
        ];
    }
}
