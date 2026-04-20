<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

final readonly class RepositoryRulesetConditionsRepositoryNameTargetRepository_name
{
    /**
     * @param ?list<string> $exclude
     * @param ?list<string> $include
     */
    public function __construct(
        public ?array $exclude = null,
        public ?array $include = null,
        public ?bool $protected = null,
    ) {
    }
}
