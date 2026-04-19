<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Enum;

enum ApiEvaluationMetricCategory: string
{
    case MetricCategoryUnspecified = 'METRIC_CATEGORY_UNSPECIFIED';
    case MetricCategoryCorrectness = 'METRIC_CATEGORY_CORRECTNESS';
    case MetricCategoryUserOutcomes = 'METRIC_CATEGORY_USER_OUTCOMES';
    case MetricCategorySafetyAndSecurity = 'METRIC_CATEGORY_SAFETY_AND_SECURITY';
    case MetricCategoryContextQuality = 'METRIC_CATEGORY_CONTEXT_QUALITY';
    case MetricCategoryModelFit = 'METRIC_CATEGORY_MODEL_FIT';
}
