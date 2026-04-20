<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

final readonly class RepositoryRuleCopilotCodeReviewParameters
{
    public function __construct(
        public ?bool $review_draft_pull_requests = null,
        public ?bool $review_on_push = null,
    ) {
    }
}
