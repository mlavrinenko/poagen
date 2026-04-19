<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Enum;

enum ApiGuardrailType: string
{
    case GuardrailTypeUnknown = 'GUARDRAIL_TYPE_UNKNOWN';
    case GuardrailTypeJailbreak = 'GUARDRAIL_TYPE_JAILBREAK';
    case GuardrailTypeSensitiveData = 'GUARDRAIL_TYPE_SENSITIVE_DATA';
    case GuardrailTypeContentModeration = 'GUARDRAIL_TYPE_CONTENT_MODERATION';
}
