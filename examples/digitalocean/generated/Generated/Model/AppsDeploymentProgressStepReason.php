<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

final readonly class AppsDeploymentProgressStepReason
{
    public function __construct(
        public ?string $code = null,
        public ?string $message = null,
    ) {
    }
}
