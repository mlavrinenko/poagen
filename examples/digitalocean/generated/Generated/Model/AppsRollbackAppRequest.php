<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

final readonly class AppsRollbackAppRequest
{
    public function __construct(
        public ?string $deployment_id = null,
        public ?bool $skip_pin = null,
    ) {
    }
}
