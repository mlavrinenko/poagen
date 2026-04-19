<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Enum;

enum ApiEvaluationMetricValueType: string
{
    case MetricValueTypeUnspecified = 'METRIC_VALUE_TYPE_UNSPECIFIED';
    case MetricValueTypeNumber = 'METRIC_VALUE_TYPE_NUMBER';
    case MetricValueTypeString = 'METRIC_VALUE_TYPE_STRING';
    case MetricValueTypePercentage = 'METRIC_VALUE_TYPE_PERCENTAGE';
}
