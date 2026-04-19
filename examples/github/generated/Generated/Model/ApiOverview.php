<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

use JsonSerializable;

final readonly class ApiOverview implements JsonSerializable
{
    /**
     * Paogen marshal/unmarshal contract — phpName => [wireKey, shape]. See ADR-007.
     * @var array<string, array{0: string, 1: null|class-string|array{0: string, 1: null|class-string}|array{0: string, 1: list<class-string>, 2: ?string}}>
     */
    public const array PROPERTY_MAP = [
        'verifiable_password_authentication' => ['verifiable_password_authentication', null],
        'actions' => ['actions', ['list', null]],
        'actions_macos' => ['actions_macos', ['list', null]],
        'api' => ['api', ['list', null]],
        'codespaces' => ['codespaces', ['list', null]],
        'copilot' => ['copilot', ['list', null]],
        'dependabot' => ['dependabot', ['list', null]],
        'domains' => ['domains', \Acme\GitHub\Generated\Model\ApiOverviewDomains::class],
        'git' => ['git', ['list', null]],
        'github_enterprise_importer' => ['github_enterprise_importer', ['list', null]],
        'hooks' => ['hooks', ['list', null]],
        'importer' => ['importer', ['list', null]],
        'packages' => ['packages', ['list', null]],
        'pages' => ['pages', ['list', null]],
        'ssh_key_fingerprints' => [
            'ssh_key_fingerprints',
            \Acme\GitHub\Generated\Model\ApiOverviewSsh_key_fingerprints::class,
        ],
        'ssh_keys' => ['ssh_keys', ['list', null]],
        'web' => ['web', ['list', null]],
    ];

    /**
     * @param ?list<string> $actions
     * @param ?list<string> $actions_macos
     * @param ?list<string> $api
     * @param ?list<string> $codespaces
     * @param ?list<string> $copilot
     * @param ?list<string> $dependabot
     * @param ?list<string> $git
     * @param ?list<string> $github_enterprise_importer
     * @param ?list<string> $hooks
     * @param ?list<string> $importer
     * @param ?list<string> $packages
     * @param ?list<string> $pages
     * @param ?list<string> $ssh_keys
     * @param ?list<string> $web
     */
    public function __construct(
        public bool $verifiable_password_authentication,
        public ?array $actions = null,
        public ?array $actions_macos = null,
        public ?array $api = null,
        public ?array $codespaces = null,
        public ?array $copilot = null,
        public ?array $dependabot = null,
        public ?ApiOverviewDomains $domains = null,
        public ?array $git = null,
        public ?array $github_enterprise_importer = null,
        public ?array $hooks = null,
        public ?array $importer = null,
        public ?array $packages = null,
        public ?array $pages = null,
        public ?ApiOverviewSsh_key_fingerprints $ssh_key_fingerprints = null,
        public ?array $ssh_keys = null,
        public ?array $web = null,
    ) {
    }

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'verifiable_password_authentication' => $this->verifiable_password_authentication,
            'actions' => $this->actions,
            'actions_macos' => $this->actions_macos,
            'api' => $this->api,
            'codespaces' => $this->codespaces,
            'copilot' => $this->copilot,
            'dependabot' => $this->dependabot,
            'domains' => $this->domains,
            'git' => $this->git,
            'github_enterprise_importer' => $this->github_enterprise_importer,
            'hooks' => $this->hooks,
            'importer' => $this->importer,
            'packages' => $this->packages,
            'pages' => $this->pages,
            'ssh_key_fingerprints' => $this->ssh_key_fingerprints,
            'ssh_keys' => $this->ssh_keys,
            'web' => $this->web,
        ];
    }
}
