<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

final readonly class PagesHealthCheck
{
    public function __construct(
        public ?PagesHealthCheckAlt_domain $alt_domain = null,
        public ?PagesHealthCheckDomain $domain = null,
    ) {
    }
}
