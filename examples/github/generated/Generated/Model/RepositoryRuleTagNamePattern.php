<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

final readonly class RepositoryRuleTagNamePattern
{
    public function __construct(
        public string $type,
        public ?RepositoryRuleTagNamePatternParameters $parameters = null,
    ) {
    }
}
