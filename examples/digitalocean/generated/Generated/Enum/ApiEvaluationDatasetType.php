<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Enum;

enum ApiEvaluationDatasetType: string
{
    case EvaluationDatasetTypeUnknown = 'EVALUATION_DATASET_TYPE_UNKNOWN';
    case EvaluationDatasetTypeAdk = 'EVALUATION_DATASET_TYPE_ADK';
    case EvaluationDatasetTypeNonAdk = 'EVALUATION_DATASET_TYPE_NON_ADK';
}
