<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

final readonly class ApiCreateEvaluationTestCaseInputPublic
{
    /**
     * @param ?list<string> $metrics
     */
    public function __construct(
        public ?string $agent_workspace_name = null,
        public ?string $dataset_uuid = null,
        public ?string $description = null,
        public ?array $metrics = null,
        public ?string $name = null,
        public ?ApiStarMetric $star_metric = null,
        public ?string $workspace_uuid = null,
    ) {
    }
}
