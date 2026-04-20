<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

final readonly class ApiEvaluationTestCaseMetricList
{
    /**
     * @param ?list<string> $metric_uuids
     */
    public function __construct(
        public ?array $metric_uuids = null,
    ) {
    }
}
