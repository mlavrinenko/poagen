<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Enum;

enum ApiRetrievalMethod: string
{
    case RetrievalMethodUnknown = 'RETRIEVAL_METHOD_UNKNOWN';
    case RetrievalMethodRewrite = 'RETRIEVAL_METHOD_REWRITE';
    case RetrievalMethodStepBack = 'RETRIEVAL_METHOD_STEP_BACK';
    case RetrievalMethodSubQueries = 'RETRIEVAL_METHOD_SUB_QUERIES';
    case RetrievalMethodNone = 'RETRIEVAL_METHOD_NONE';
}
