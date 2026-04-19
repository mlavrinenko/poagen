<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Enum;

enum ApiModelProvider: string
{
    case ModelProviderDigitalocean = 'MODEL_PROVIDER_DIGITALOCEAN';
    case ModelProviderAnthropic = 'MODEL_PROVIDER_ANTHROPIC';
    case ModelProviderOpenai = 'MODEL_PROVIDER_OPENAI';
}
