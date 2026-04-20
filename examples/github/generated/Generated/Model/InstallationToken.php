<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

final readonly class InstallationToken
{
    /**
     * @param ?list<\Acme\GitHub\Generated\Model\Repository> $repositories
     * @param ?list<string> $single_file_paths
     */
    public function __construct(
        public string $expires_at,
        public string $token,
        public ?bool $has_multiple_single_files = null,
        public ?AppPermissions $permissions = null,
        public ?array $repositories = null,
        public ?string $repository_selection = null,
        public ?string $single_file = null,
        public ?array $single_file_paths = null,
    ) {
    }
}
