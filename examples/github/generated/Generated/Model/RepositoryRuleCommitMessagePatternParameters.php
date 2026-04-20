<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

final readonly class RepositoryRuleCommitMessagePatternParameters
{
    public function __construct(
        public string $operator,
        public string $pattern,
        public ?string $name = null,
        public ?bool $negate = null,
    ) {
    }
}
