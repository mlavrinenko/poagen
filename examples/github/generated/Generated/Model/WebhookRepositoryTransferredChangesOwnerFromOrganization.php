<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

final readonly class WebhookRepositoryTransferredChangesOwnerFromOrganization
{
    public function __construct(
        public string $avatar_url,
        public ?string $description = null,
        public string $events_url,
        public string $hooks_url,
        public int $id,
        public string $issues_url,
        public string $login,
        public string $members_url,
        public string $node_id,
        public string $public_members_url,
        public string $repos_url,
        public string $url,
        public ?string $html_url = null,
    ) {
    }
}
