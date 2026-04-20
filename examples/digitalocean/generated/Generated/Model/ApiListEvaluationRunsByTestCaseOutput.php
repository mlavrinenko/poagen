<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

final readonly class ApiListEvaluationRunsByTestCaseOutput
{
    /**
     * @param ?list<\Acme\DigitalOcean\Generated\Model\ApiEvaluationRun> $evaluation_runs
     */
    public function __construct(
        public ?array $evaluation_runs = null,
    ) {
    }
}
