<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

use DateTimeImmutable;

final readonly class WebhookIssuesDemilestonedIssueMilestone
{
    public function __construct(
        public ?DateTimeImmutable $closed_at = null,
        public int $closed_issues,
        public DateTimeImmutable $created_at,
        public WebhookIssuesDemilestonedIssueMilestoneCreator $creator,
        public ?string $description = null,
        public ?DateTimeImmutable $due_on = null,
        public string $html_url,
        public int $id,
        public string $labels_url,
        public string $node_id,
        public int $number,
        public int $open_issues,
        public string $state,
        public string $title,
        public DateTimeImmutable $updated_at,
        public string $url,
    ) {
    }
}
