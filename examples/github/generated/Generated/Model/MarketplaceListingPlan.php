<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

final readonly class MarketplaceListingPlan
{
    /**
     * @param list<string> $bullets
     */
    public function __construct(
        public string $accounts_url,
        public array $bullets,
        public string $description,
        public bool $has_free_trial,
        public int $id,
        public int $monthly_price_in_cents,
        public string $name,
        public int $number,
        public string $price_model,
        public string $state,
        public ?string $unit_name = null,
        public string $url,
        public int $yearly_price_in_cents,
    ) {
    }
}
