<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

use DateTimeImmutable;

final readonly class WebhookIssuesLockedIssuePerformed_via_github_app
{
    /**
     * @param ?list<string> $events
     */
    public function __construct(
        public ?DateTimeImmutable $created_at = null,
        public ?string $description = null,
        public ?string $external_url = null,
        public string $html_url,
        public ?int $id = null,
        public string $name,
        public string $node_id,
        public WebhookIssuesLockedIssuePerformed_via_github_appOwner $owner,
        public ?DateTimeImmutable $updated_at = null,
        public ?array $events = null,
        public ?WebhookIssuesLockedIssuePerformed_via_github_appPermissions $permissions = null,
        public ?string $slug = null,
    ) {
    }
}
