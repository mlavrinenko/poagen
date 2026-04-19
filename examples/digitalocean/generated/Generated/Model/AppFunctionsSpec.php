<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

use JsonSerializable;

final readonly class AppFunctionsSpec implements JsonSerializable
{
    /**
     * Paogen marshal/unmarshal contract — phpName => [wireKey, shape]. See ADR-007.
     * @var array<string, array{0: string, 1: null|class-string|array{0: string, 1: null|class-string}|array{0: string, 1: list<class-string>, 2: ?string}}>
     */
    public const array PROPERTY_MAP = [
        'name' => ['name', null],
        'alerts' => ['alerts', ['list', \Acme\DigitalOcean\Generated\Model\AppAlertSpec::class]],
        'bitbucket' => ['bitbucket', \Acme\DigitalOcean\Generated\Model\AppsBitbucketSourceSpec::class],
        'cors' => ['cors', null],
        'envs' => ['envs', ['list', \Acme\DigitalOcean\Generated\Model\AppVariableDefinition::class]],
        'git' => ['git', \Acme\DigitalOcean\Generated\Model\AppsGitSourceSpec::class],
        'github' => ['github', \Acme\DigitalOcean\Generated\Model\AppsGithubSourceSpec::class],
        'gitlab' => ['gitlab', \Acme\DigitalOcean\Generated\Model\AppsGitlabSourceSpec::class],
        'log_destinations' => [
            'log_destinations',
            ['list', \Acme\DigitalOcean\Generated\Model\AppLogDestinationDefinition::class],
        ],
        'routes' => ['routes', ['list', \Acme\DigitalOcean\Generated\Model\AppRouteSpec::class]],
        'source_dir' => ['source_dir', null],
    ];

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

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'name' => $this->name,
            'alerts' => $this->alerts,
            'bitbucket' => $this->bitbucket,
            'cors' => $this->cors,
            'envs' => $this->envs,
            'git' => $this->git,
            'github' => $this->github,
            'gitlab' => $this->gitlab,
            'log_destinations' => $this->log_destinations,
            'routes' => $this->routes,
            'source_dir' => $this->source_dir,
        ];
    }
}
