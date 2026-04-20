<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

final readonly class RepositoryRuleWorkflowsParameters
{
    /**
     * @param list<\Acme\GitHub\Generated\Model\RepositoryRuleParamsWorkflowFileReference> $workflows
     */
    public function __construct(
        public array $workflows,
        public ?bool $do_not_enforce_on_create = null,
    ) {
    }
}
