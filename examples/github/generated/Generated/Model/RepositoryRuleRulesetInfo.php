<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

final readonly class RepositoryRuleRulesetInfo
{
    public function __construct(
        public ?int $ruleset_id = null,
        public ?string $ruleset_source = null,
        public ?string $ruleset_source_type = null,
    ) {
    }
}
