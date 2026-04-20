<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

use DateTimeImmutable;

final readonly class Installation
{
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
}
