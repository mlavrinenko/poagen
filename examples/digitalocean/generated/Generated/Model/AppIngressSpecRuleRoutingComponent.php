<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

final readonly class AppIngressSpecRuleRoutingComponent
{
    public function __construct(
        public string $name,
        public ?string $preserve_path_prefix = null,
        public ?string $rewrite = null,
    ) {
    }
}
