<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

use JsonSerializable;

final readonly class NullableScopedInstallation implements JsonSerializable
{
    /**
     * Paogen marshal/unmarshal contract — phpName => [wireKey, shape]. See ADR-007.
     * @var array<string, array{0: string, 1: null|class-string|array{0: string, 1: null|class-string}|array{0: string, 1: list<class-string>, 2: ?string}}>
     */
    public const array PROPERTY_MAP = [
        'account' => ['account', \Acme\GitHub\Generated\Model\SimpleUser::class],
        'permissions' => ['permissions', \Acme\GitHub\Generated\Model\AppPermissions::class],
        'repositories_url' => ['repositories_url', null],
        'repository_selection' => ['repository_selection', null],
        'single_file_name' => ['single_file_name', null],
        'has_multiple_single_files' => ['has_multiple_single_files', null],
        'single_file_paths' => ['single_file_paths', ['list', null]],
    ];

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

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'account' => $this->account,
            'permissions' => $this->permissions,
            'repositories_url' => $this->repositories_url,
            'repository_selection' => $this->repository_selection,
            'single_file_name' => $this->single_file_name,
            'has_multiple_single_files' => $this->has_multiple_single_files,
            'single_file_paths' => $this->single_file_paths,
        ];
    }
}
