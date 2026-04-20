<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

final readonly class RuleSuiteRequiredStatusChecks
{
    /**
     * @param ?list<array<string, mixed>> $checks
     */
    public function __construct(
        public ?array $checks = null,
    ) {
    }
}
