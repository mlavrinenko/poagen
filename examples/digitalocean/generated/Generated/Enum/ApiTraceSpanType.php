<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Enum;

enum ApiTraceSpanType: string
{
    case TraceSpanTypeUnknown = 'TRACE_SPAN_TYPE_UNKNOWN';
    case TraceSpanTypeLlm = 'TRACE_SPAN_TYPE_LLM';
    case TraceSpanTypeRetriever = 'TRACE_SPAN_TYPE_RETRIEVER';
    case TraceSpanTypeTool = 'TRACE_SPAN_TYPE_TOOL';
}
