<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

final readonly class ReviewRequestedIssueEvent
{
    public function __construct(
        public SimpleUser $actor,
        public ?string $commit_id = null,
        public ?string $commit_url = null,
        public string $created_at,
        public string $event,
        public int $id,
        public string $node_id,
        public NullableIntegration $performed_via_github_app,
        public SimpleUser $review_requester,
        public string $url,
        public ?SimpleUser $requested_reviewer = null,
        public ?Team $requested_team = null,
    ) {
    }
}
