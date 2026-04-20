<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

final readonly class RepositoryRuleRequiredStatusChecksParameters
{
    /**
     * @param list<\Acme\GitHub\Generated\Model\RepositoryRuleParamsStatusCheckConfiguration> $required_status_checks
     */
    public function __construct(
        public array $required_status_checks,
        public bool $strict_required_status_checks_policy,
        public ?bool $do_not_enforce_on_create = null,
    ) {
    }
}
