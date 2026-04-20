<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

final readonly class AutoscalePoolCreate
{
    public function __construct(
        public AutoscalePoolStaticConfig|AutoscalePoolDynamicConfig $config,
        public AutoscalePoolDropletTemplate $droplet_template,
        public string $name,
    ) {
    }
}
