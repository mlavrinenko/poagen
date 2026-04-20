<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

final readonly class ApiUpdateEvaluationTestCaseInputPublic
{
    public function __construct(
        public ?string $dataset_uuid = null,
        public ?string $description = null,
        public ?ApiEvaluationTestCaseMetricList $metrics = null,
        public ?string $name = null,
        public ?ApiStarMetric $star_metric = null,
        public ?string $test_case_uuid = null,
    ) {
    }
}
