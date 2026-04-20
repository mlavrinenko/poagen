<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

final readonly class RepositoryRulesetConditionsRepositoryPropertyTargetRepository_property
{
    /**
     * @param ?list<\Acme\GitHub\Generated\Model\RepositoryRulesetConditionsRepositoryPropertySpec> $exclude
     * @param ?list<\Acme\GitHub\Generated\Model\RepositoryRulesetConditionsRepositoryPropertySpec> $include
     */
    public function __construct(
        public ?array $exclude = null,
        public ?array $include = null,
    ) {
    }
}
