<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Enum;

enum DomainsListRecordsType: string
{
    case A = 'A';
    case Aaaa = 'AAAA';
    case Caa = 'CAA';
    case Cname = 'CNAME';
    case Mx = 'MX';
    case Ns = 'NS';
    case Soa = 'SOA';
    case Srv = 'SRV';
    case Txt = 'TXT';
}
