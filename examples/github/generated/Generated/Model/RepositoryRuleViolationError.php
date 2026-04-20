<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

final readonly class RepositoryRuleViolationError
{
    public function __construct(
        public ?string $documentation_url = null,
        public ?string $message = null,
        public ?RepositoryRuleViolationErrorMetadata $metadata = null,
        public ?string $status = null,
    ) {
    }
}
