<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

use Acme\DigitalOcean\Generated\Enum\ApiEvaluationMetricValueType;

final readonly class ApiEvaluationMetricResult
{
    public function __construct(
        public ?string $error_description = null,
        public ?string $metric_name = null,
        public ?ApiEvaluationMetricValueType $metric_value_type = null,
        public ?float $number_value = null,
        public ?string $reasoning = null,
        public ?string $string_value = null,
    ) {
    }
}
