<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

use JsonSerializable;

final readonly class InstallationToken implements JsonSerializable
{
    /**
     * Paogen marshal/unmarshal contract — phpName => [wireKey, shape]. See ADR-007.
     * @var array<string, array{0: string, 1: null|class-string|array{0: string, 1: null|class-string}|array{0: string, 1: list<class-string>, 2: ?string}}>
     */
    public const array PROPERTY_MAP = [
        'expires_at' => ['expires_at', null],
        'token' => ['token', null],
        'has_multiple_single_files' => ['has_multiple_single_files', null],
        'permissions' => ['permissions', \Acme\GitHub\Generated\Model\AppPermissions::class],
        'repositories' => ['repositories', ['list', \Acme\GitHub\Generated\Model\Repository::class]],
        'repository_selection' => ['repository_selection', null],
        'single_file' => ['single_file', null],
        'single_file_paths' => ['single_file_paths', ['list', null]],
    ];

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

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'expires_at' => $this->expires_at,
            'token' => $this->token,
            'has_multiple_single_files' => $this->has_multiple_single_files,
            'permissions' => $this->permissions,
            'repositories' => $this->repositories,
            'repository_selection' => $this->repository_selection,
            'single_file' => $this->single_file,
            'single_file_paths' => $this->single_file_paths,
        ];
    }
}
