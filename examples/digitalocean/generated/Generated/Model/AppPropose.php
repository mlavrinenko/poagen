<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

final readonly class AppPropose
{
    public function __construct(
        public AppSpec $spec,
        public ?string $app_id = null,
    ) {
    }
}
