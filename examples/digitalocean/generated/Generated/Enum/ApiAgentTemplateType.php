<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Enum;

enum ApiAgentTemplateType: string
{
    case AgentTemplateTypeStandard = 'AGENT_TEMPLATE_TYPE_STANDARD';
    case AgentTemplateTypeOneClick = 'AGENT_TEMPLATE_TYPE_ONE_CLICK';
}
