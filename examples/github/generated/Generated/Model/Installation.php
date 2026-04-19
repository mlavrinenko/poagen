<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

use DateTimeImmutable;
use JsonSerializable;

final readonly class Installation implements JsonSerializable
{
    /**
     * Paogen marshal/unmarshal contract — phpName => [wireKey, shape]. See ADR-007.
     * @var array<string, array{0: string, 1: null|class-string|array{0: string, 1: null|class-string}|array{0: string, 1: list<class-string>, 2: ?string}}>
     */
    public const array PROPERTY_MAP = [
        'access_tokens_url' => ['access_tokens_url', null],
        'account' => [
            'account',
            [
                'union',
                [\Acme\GitHub\Generated\Model\SimpleUser::class, \Acme\GitHub\Generated\Model\Enterprise::class],
                null,
            ],
        ],
        'app_id' => ['app_id', null],
        'app_slug' => ['app_slug', null],
        'created_at' => ['created_at', ['datetime', null]],
        'events' => ['events', ['list', null]],
        'html_url' => ['html_url', null],
        'id' => ['id', null],
        'permissions' => ['permissions', \Acme\GitHub\Generated\Model\AppPermissions::class],
        'repositories_url' => ['repositories_url', null],
        'repository_selection' => ['repository_selection', null],
        'single_file_name' => ['single_file_name', null],
        'suspended_at' => ['suspended_at', ['datetime', null]],
        'suspended_by' => ['suspended_by', \Acme\GitHub\Generated\Model\NullableSimpleUser::class],
        'target_id' => ['target_id', null],
        'target_type' => ['target_type', null],
        'updated_at' => ['updated_at', ['datetime', null]],
        'client_id' => ['client_id', null],
        'contact_email' => ['contact_email', null],
        'has_multiple_single_files' => ['has_multiple_single_files', null],
        'single_file_paths' => ['single_file_paths', ['list', null]],
    ];

    /**
     * @param list<string> $events
     * @param ?list<string> $single_file_paths
     */
    public function __construct(
        public string $access_tokens_url,
        public SimpleUser|Enterprise|null $account = null,
        public int $app_id,
        public string $app_slug,
        public DateTimeImmutable $created_at,
        public array $events,
        public string $html_url,
        public int $id,
        public AppPermissions $permissions,
        public string $repositories_url,
        public string $repository_selection,
        public ?string $single_file_name = null,
        public ?DateTimeImmutable $suspended_at = null,
        public NullableSimpleUser $suspended_by,
        public int $target_id,
        public string $target_type,
        public DateTimeImmutable $updated_at,
        public ?string $client_id = null,
        public ?string $contact_email = null,
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
            'access_tokens_url' => $this->access_tokens_url,
            'account' => $this->account,
            'app_id' => $this->app_id,
            'app_slug' => $this->app_slug,
            'created_at' => $this->created_at->format(\DateTimeInterface::RFC3339),
            'events' => $this->events,
            'html_url' => $this->html_url,
            'id' => $this->id,
            'permissions' => $this->permissions,
            'repositories_url' => $this->repositories_url,
            'repository_selection' => $this->repository_selection,
            'single_file_name' => $this->single_file_name,
            'suspended_at' => $this->suspended_at?->format(\DateTimeInterface::RFC3339),
            'suspended_by' => $this->suspended_by,
            'target_id' => $this->target_id,
            'target_type' => $this->target_type,
            'updated_at' => $this->updated_at->format(\DateTimeInterface::RFC3339),
            'client_id' => $this->client_id,
            'contact_email' => $this->contact_email,
            'has_multiple_single_files' => $this->has_multiple_single_files,
            'single_file_paths' => $this->single_file_paths,
        ];
    }
}
