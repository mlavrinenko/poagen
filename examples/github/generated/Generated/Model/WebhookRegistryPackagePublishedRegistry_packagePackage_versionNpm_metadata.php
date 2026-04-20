<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

final readonly class WebhookRegistryPackagePublishedRegistry_packagePackage_versionNpm_metadata
{
    /**
     * @param ?mixed $author
     * @param ?array<string, mixed> $bin
     * @param ?mixed $bugs
     * @param ?list<string> $contributors
     * @param ?list<string> $cpu
     * @param ?array<string, mixed> $dependencies
     * @param ?array<string, mixed> $dev_dependencies
     * @param ?mixed $directories
     * @param ?mixed $dist
     * @param ?array<string, mixed> $engines
     * @param ?list<string> $files
     * @param ?list<string> $keywords
     * @param ?list<string> $maintainers
     * @param ?array<string, mixed> $man
     * @param ?array<string, mixed> $optional_dependencies
     * @param ?list<string> $os
     * @param ?array<string, mixed> $peer_dependencies
     * @param ?mixed $repository
     * @param ?array<string, mixed> $scripts
     */
    public function __construct(
        public $author = null,
        public ?array $bin = null,
        public $bugs = null,
        public ?string $commit_oid = null,
        public ?array $contributors = null,
        public ?array $cpu = null,
        public ?int $deleted_by_id = null,
        public ?array $dependencies = null,
        public ?string $description = null,
        public ?array $dev_dependencies = null,
        public $directories = null,
        public $dist = null,
        public ?array $engines = null,
        public ?array $files = null,
        public ?string $git_head = null,
        public ?bool $has_shrinkwrap = null,
        public ?string $homepage = null,
        public ?string $id = null,
        public ?string $installation_command = null,
        public ?array $keywords = null,
        public ?string $license = null,
        public ?string $main = null,
        public ?array $maintainers = null,
        public ?array $man = null,
        public ?string $name = null,
        public ?string $node_version = null,
        public ?string $npm_user = null,
        public ?string $npm_version = null,
        public ?array $optional_dependencies = null,
        public ?array $os = null,
        public ?array $peer_dependencies = null,
        public ?bool $published_via_actions = null,
        public ?string $readme = null,
        public ?int $release_id = null,
        public $repository = null,
        public ?array $scripts = null,
        public ?string $version = null,
    ) {
    }
}
