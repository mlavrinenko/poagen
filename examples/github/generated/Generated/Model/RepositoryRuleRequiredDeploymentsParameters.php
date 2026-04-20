<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

final readonly class RepositoryRuleRequiredDeploymentsParameters
{
    /**
     * @param list<string> $required_deployment_environments
     */
    public function __construct(
        public array $required_deployment_environments,
    ) {
    }
}
