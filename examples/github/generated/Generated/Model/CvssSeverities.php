<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

final readonly class CvssSeverities
{
    public function __construct(
        public ?CvssSeveritiesCvss_v3 $cvss_v3 = null,
        public ?CvssSeveritiesCvss_v4 $cvss_v4 = null,
    ) {
    }
}
