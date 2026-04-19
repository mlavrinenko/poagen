<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Enum;

enum ApiModelUsecase: string
{
    case ModelUsecaseUnknown = 'MODEL_USECASE_UNKNOWN';
    case ModelUsecaseAgent = 'MODEL_USECASE_AGENT';
    case ModelUsecaseFinetuned = 'MODEL_USECASE_FINETUNED';
    case ModelUsecaseKnowledgebase = 'MODEL_USECASE_KNOWLEDGEBASE';
    case ModelUsecaseGuardrail = 'MODEL_USECASE_GUARDRAIL';
    case ModelUsecaseReasoning = 'MODEL_USECASE_REASONING';
    case ModelUsecaseServerless = 'MODEL_USECASE_SERVERLESS';
}
