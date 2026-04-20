<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

final readonly class AppProposeResponse
{
    public function __construct(
        public ?int $app_cost = null,
        public ?bool $app_is_static = null,
        public ?bool $app_name_available = null,
        public ?string $app_name_suggestion = null,
        public ?int $app_tier_downgrade_cost = null,
        public ?string $existing_static_apps = null,
        public ?AppSpec $spec = null,
    ) {
    }
}
