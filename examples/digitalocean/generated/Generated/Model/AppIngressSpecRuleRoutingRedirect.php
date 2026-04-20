<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

final readonly class AppIngressSpecRuleRoutingRedirect
{
    public function __construct(
        public ?string $authority = null,
        public ?int $port = null,
        public ?int $redirect_code = null,
        public ?string $scheme = null,
        public ?string $uri = null,
    ) {
    }
}
