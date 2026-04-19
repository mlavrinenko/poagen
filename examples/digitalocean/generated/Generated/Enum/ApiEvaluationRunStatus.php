<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Enum;

enum ApiEvaluationRunStatus: string
{
    case EvaluationRunStatusUnspecified = 'EVALUATION_RUN_STATUS_UNSPECIFIED';
    case EvaluationRunQueued = 'EVALUATION_RUN_QUEUED';
    case EvaluationRunRunningDataset = 'EVALUATION_RUN_RUNNING_DATASET';
    case EvaluationRunEvaluatingResults = 'EVALUATION_RUN_EVALUATING_RESULTS';
    case EvaluationRunCancelling = 'EVALUATION_RUN_CANCELLING';
    case EvaluationRunCancelled = 'EVALUATION_RUN_CANCELLED';
    case EvaluationRunSuccessful = 'EVALUATION_RUN_SUCCESSFUL';
    case EvaluationRunPartiallySuccessful = 'EVALUATION_RUN_PARTIALLY_SUCCESSFUL';
    case EvaluationRunFailed = 'EVALUATION_RUN_FAILED';
}
