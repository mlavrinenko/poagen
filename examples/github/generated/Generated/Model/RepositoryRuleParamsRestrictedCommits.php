<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

final readonly class RepositoryRuleParamsRestrictedCommits
{
    public function __construct(
        public string $oid,
        public ?string $reason = null,
    ) {
    }
}
