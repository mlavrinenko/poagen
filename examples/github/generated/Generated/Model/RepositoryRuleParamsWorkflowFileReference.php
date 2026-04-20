<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

final readonly class RepositoryRuleParamsWorkflowFileReference
{
    public function __construct(
        public string $path,
        public int $repository_id,
        public ?string $ref = null,
        public ?string $sha = null,
    ) {
    }
}
