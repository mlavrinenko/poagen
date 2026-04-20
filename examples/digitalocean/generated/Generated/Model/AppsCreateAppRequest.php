<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

final readonly class AppsCreateAppRequest
{
    public function __construct(
        public AppSpec $spec,
        public ?string $project_id = null,
    ) {
    }
}
