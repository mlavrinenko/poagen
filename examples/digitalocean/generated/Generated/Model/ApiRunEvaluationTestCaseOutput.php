<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

final readonly class ApiRunEvaluationTestCaseOutput
{
    /**
     * @param ?list<string> $evaluation_run_uuids
     */
    public function __construct(
        public ?array $evaluation_run_uuids = null,
    ) {
    }
}
