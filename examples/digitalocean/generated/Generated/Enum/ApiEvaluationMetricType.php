<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Enum;

enum ApiEvaluationMetricType: string
{
    case MetricTypeUnspecified = 'METRIC_TYPE_UNSPECIFIED';
    case MetricTypeGeneralQuality = 'METRIC_TYPE_GENERAL_QUALITY';
    case MetricTypeRagAndTool = 'METRIC_TYPE_RAG_AND_TOOL';
}
