<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

use DateTimeImmutable;

final readonly class AddonsPlan
{
    /**
     * @param ?list<\Acme\DigitalOcean\Generated\Model\AddonsDimensionWithPrice> $dimensions
     * @param ?list<\Acme\DigitalOcean\Generated\Model\AddonsFeature> $features
     */
    public function __construct(
        public bool $active,
        public int $app_id,
        public bool $available,
        public bool $by_default,
        public DateTimeImmutable $created_at,
        public string $display_name,
        public int $id,
        public int $price_per_month,
        public string $slug,
        public string $state,
        public DateTimeImmutable $updated_at,
        public string $uuid,
        public ?string $description = null,
        public ?array $dimensions = null,
        public ?array $features = null,
    ) {
    }
}
