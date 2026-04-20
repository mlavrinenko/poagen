<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

final readonly class WebhookPullRequestReviewRequestRemovedBranch2Requested_team
{
    public function __construct(
        public ?string $description = null,
        public string $html_url,
        public int $id,
        public string $members_url,
        public string $name,
        public string $node_id,
        public string $permission,
        public string $privacy,
        public string $repositories_url,
        public string $slug,
        public string $url,
        public ?bool $deleted = null,
        public ?WebhookPullRequestReviewRequestRemovedBranch2Requested_teamParent $parent = null,
    ) {
    }
}
