<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

final readonly class ApiListEvaluationTestCasesByWorkspaceOutput
{
    /**
     * @param ?list<\Acme\DigitalOcean\Generated\Model\ApiEvaluationTestCase> $evaluation_test_cases
     */
    public function __construct(
        public ?array $evaluation_test_cases = null,
    ) {
    }
}
