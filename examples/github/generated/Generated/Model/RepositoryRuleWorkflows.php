<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

final readonly class RepositoryRuleWorkflows
{
    public function __construct(
        public string $type,
        public ?RepositoryRuleWorkflowsParameters $parameters = null,
    ) {
    }
}
