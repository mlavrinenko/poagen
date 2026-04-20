<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

final readonly class AppIngressSpecRuleMatch
{
    public function __construct(
        public ?AppIngressSpecRuleStringMatchExact $authority = null,
        public ?AppIngressSpecRuleStringMatchPrefix $path = null,
    ) {
    }
}
