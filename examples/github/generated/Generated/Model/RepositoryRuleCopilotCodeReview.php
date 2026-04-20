<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

final readonly class RepositoryRuleCopilotCodeReview
{
    public function __construct(
        public string $type,
        public ?RepositoryRuleCopilotCodeReviewParameters $parameters = null,
    ) {
    }
}
