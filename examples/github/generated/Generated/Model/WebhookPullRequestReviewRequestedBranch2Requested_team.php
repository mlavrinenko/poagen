<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

final readonly class WebhookPullRequestReviewRequestedBranch2Requested_team
{
    public function __construct(
        public int $id,
        public string $name,
        public ?bool $deleted = null,
        public ?string $description = null,
        public ?string $html_url = null,
        public ?string $members_url = null,
        public ?string $node_id = null,
        public ?WebhookPullRequestReviewRequestedBranch2Requested_teamParent $parent = null,
        public ?string $permission = null,
        public ?string $privacy = null,
        public ?string $repositories_url = null,
        public ?string $slug = null,
        public ?string $url = null,
    ) {
    }
}
