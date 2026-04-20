<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

final readonly class ApiListEvaluationMetricsOutput
{
    /**
     * @param ?list<\Acme\DigitalOcean\Generated\Model\ApiEvaluationMetric> $metrics
     */
    public function __construct(
        public ?array $metrics = null,
    ) {
    }
}
