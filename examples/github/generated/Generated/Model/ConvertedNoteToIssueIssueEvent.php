<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

final readonly class ConvertedNoteToIssueIssueEvent
{
    public function __construct(
        public SimpleUser $actor,
        public ?string $commit_id = null,
        public ?string $commit_url = null,
        public string $created_at,
        public string $event,
        public int $id,
        public string $node_id,
        public Integration $performed_via_github_app,
        public string $url,
        public ?ConvertedNoteToIssueIssueEventProject_card $project_card = null,
    ) {
    }
}
