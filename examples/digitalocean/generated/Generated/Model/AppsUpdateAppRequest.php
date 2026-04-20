<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

final readonly class AppsUpdateAppRequest
{
    public function __construct(
        public AppSpec $spec,
        public ?bool $update_all_source_versions = null,
    ) {
    }
}
