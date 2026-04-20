<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

final readonly class AppsCreateDeploymentRequest
{
    public function __construct(
        public ?bool $force_build = null,
    ) {
    }
}
