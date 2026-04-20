<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

final readonly class AddonsResource
{
    /**
     * @param ?list<\Acme\DigitalOcean\Generated\Model\AddonsResourceMetadata> $metadata
     */
    public function __construct(
        public string $app_slug,
        public bool $has_config,
        public string $name,
        public string $plan_slug,
        public string $state,
        public string $uuid,
        public ?string $app_name = null,
        public ?string $message = null,
        public ?array $metadata = null,
        public ?string $plan_name = null,
        public ?int $plan_price_per_month = null,
        public ?string $sso_url = null,
    ) {
    }
}
