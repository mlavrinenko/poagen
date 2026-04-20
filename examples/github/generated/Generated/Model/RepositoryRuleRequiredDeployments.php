<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

final readonly class RepositoryRuleRequiredDeployments
{
    public function __construct(
        public string $type,
        public ?RepositoryRuleRequiredDeploymentsParameters $parameters = null,
    ) {
    }
}
