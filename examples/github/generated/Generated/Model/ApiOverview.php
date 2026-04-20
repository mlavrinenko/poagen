<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

final readonly class ApiOverview
{
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
}
