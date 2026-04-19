<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

use JsonSerializable;

final readonly class AppStaticSiteSpec implements JsonSerializable
{
    /**
     * Paogen marshal/unmarshal contract — phpName => [wireKey, shape]. See ADR-007.
     * @var array<string, array{0: string, 1: null|class-string|array{0: string, 1: null|class-string}|array{0: string, 1: list<class-string>, 2: ?string}}>
     */
    public const array PROPERTY_MAP = [
        'bitbucket' => ['bitbucket', \Acme\DigitalOcean\Generated\Model\AppsBitbucketSourceSpec::class],
        'build_command' => ['build_command', null],
        'catchall_document' => ['catchall_document', null],
        'cors' => ['cors', null],
        'dockerfile_path' => ['dockerfile_path', null],
        'environment_slug' => ['environment_slug', null],
        'envs' => ['envs', ['list', \Acme\DigitalOcean\Generated\Model\AppVariableDefinition::class]],
        'error_document' => ['error_document', null],
        'git' => ['git', \Acme\DigitalOcean\Generated\Model\AppsGitSourceSpec::class],
        'github' => ['github', \Acme\DigitalOcean\Generated\Model\AppsGithubSourceSpec::class],
        'gitlab' => ['gitlab', \Acme\DigitalOcean\Generated\Model\AppsGitlabSourceSpec::class],
        'image' => ['image', \Acme\DigitalOcean\Generated\Model\AppsImageSourceSpec::class],
        'index_document' => ['index_document', null],
        'log_destinations' => [
            'log_destinations',
            ['list', \Acme\DigitalOcean\Generated\Model\AppLogDestinationDefinition::class],
        ],
        'name' => ['name', null],
        'output_dir' => ['output_dir', null],
        'routes' => ['routes', ['list', \Acme\DigitalOcean\Generated\Model\AppRouteSpec::class]],
        'run_command' => ['run_command', null],
        'source_dir' => ['source_dir', null],
    ];

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

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'bitbucket' => $this->bitbucket,
            'build_command' => $this->build_command,
            'catchall_document' => $this->catchall_document,
            'cors' => $this->cors,
            'dockerfile_path' => $this->dockerfile_path,
            'environment_slug' => $this->environment_slug,
            'envs' => $this->envs,
            'error_document' => $this->error_document,
            'git' => $this->git,
            'github' => $this->github,
            'gitlab' => $this->gitlab,
            'image' => $this->image,
            'index_document' => $this->index_document,
            'log_destinations' => $this->log_destinations,
            'name' => $this->name,
            'output_dir' => $this->output_dir,
            'routes' => $this->routes,
            'run_command' => $this->run_command,
            'source_dir' => $this->source_dir,
        ];
    }
}
