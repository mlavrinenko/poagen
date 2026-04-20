<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

final readonly class RepositoryRuleParamsRequiredReviewerConfiguration
{
    /**
     * @param list<string> $file_patterns
     */
    public function __construct(
        public array $file_patterns,
        public int $minimum_approvals,
        public RepositoryRuleParamsReviewer $reviewer,
    ) {
    }
}
