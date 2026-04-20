<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

final readonly class RepositoryRuleViolationErrorMetadata
{
    public function __construct(
        public ?RepositoryRuleViolationErrorMetadataSecret_scanning $secret_scanning = null,
    ) {
    }
}
