<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

final readonly class WebhookPackagePublishedPackagePackage_versionNpm_metadata
{
    /**
     * @param ?array<string, mixed> $author
     * @param ?array<string, mixed> $bin
     * @param ?array<string, mixed> $bugs
     * @param ?list<array<string, mixed>> $contributors
     * @param ?list<string> $cpu
     * @param ?array<string, mixed> $dependencies
     * @param ?array<string, mixed> $dev_dependencies
     * @param ?array<string, mixed> $directories
     * @param ?array<string, mixed> $dist
     * @param ?array<string, mixed> $engines
     * @param ?list<string> $files
     * @param ?list<string> $keywords
     * @param ?list<array<string, mixed>> $maintainers
     * @param ?array<string, mixed> $man
     * @param ?array<string, mixed> $optional_dependencies
     * @param ?list<string> $os
     * @param ?array<string, mixed> $peer_dependencies
     * @param ?array<string, mixed> $repository
     * @param ?array<string, mixed> $scripts
     */
    public function __construct(
        public ?array $author = null,
        public ?array $bin = null,
        public ?array $bugs = null,
        public ?string $commit_oid = null,
        public ?array $contributors = null,
        public ?array $cpu = null,
        public ?int $deleted_by_id = null,
        public ?array $dependencies = null,
        public ?string $description = null,
        public ?array $dev_dependencies = null,
        public ?array $directories = null,
        public ?array $dist = null,
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
        public ?array $repository = null,
        public ?array $scripts = null,
        public ?string $version = null,
    ) {
    }
}
