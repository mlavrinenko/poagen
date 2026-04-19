<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Enum;

enum ApiCrawlingOption: string
{
    case Unknown = 'UNKNOWN';
    case Scoped = 'SCOPED';
    case Path = 'PATH';
    case Domain = 'DOMAIN';
    case Subdomains = 'SUBDOMAINS';
    case Sitemap = 'SITEMAP';
}
