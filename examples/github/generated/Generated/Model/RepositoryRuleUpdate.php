<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

final readonly class RepositoryRuleUpdate
{
    public function __construct(
        public string $type,
        public ?RepositoryRuleUpdateParameters $parameters = null,
    ) {
    }
}
