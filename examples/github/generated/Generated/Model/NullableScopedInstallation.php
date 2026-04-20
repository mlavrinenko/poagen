<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

final readonly class NullableScopedInstallation
{
    /**
     * @param ?list<string> $single_file_paths
     */
    public function __construct(
        public SimpleUser $account,
        public AppPermissions $permissions,
        public string $repositories_url,
        public string $repository_selection,
        public ?string $single_file_name = null,
        public ?bool $has_multiple_single_files = null,
        public ?array $single_file_paths = null,
    ) {
    }
}
