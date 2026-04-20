<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

final readonly class TimelineUnassignedIssueEvent
{
    public function __construct(
        public SimpleUser $actor,
        public SimpleUser $assignee,
        public ?string $commit_id = null,
        public ?string $commit_url = null,
        public string $created_at,
        public string $event,
        public int $id,
        public string $node_id,
        public NullableIntegration $performed_via_github_app,
        public string $url,
    ) {
    }
}
