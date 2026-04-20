<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

final readonly class WebhookRepositoryRulesetEditedChangesRules
{
    /**
     * @param ?list<\Acme\GitHub\Generated\Model\RepositoryRule> $added
     * @param ?list<\Acme\GitHub\Generated\Model\RepositoryRule> $deleted
     * @param ?list<array<string, mixed>> $updated
     */
    public function __construct(
        public ?array $added = null,
        public ?array $deleted = null,
        public ?array $updated = null,
    ) {
    }
}
