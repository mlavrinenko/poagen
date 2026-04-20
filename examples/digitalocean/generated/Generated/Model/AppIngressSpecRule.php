<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

final readonly class AppIngressSpecRule
{
    public function __construct(
        public ?AppIngressSpecRuleRoutingComponent $component = null,
        public ?AppsCorsPolicy $cors = null,
        public ?AppIngressSpecRuleMatch $match = null,
        public ?AppIngressSpecRuleRoutingRedirect $redirect = null,
    ) {
    }
}
