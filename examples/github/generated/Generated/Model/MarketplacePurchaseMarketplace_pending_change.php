<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

final readonly class MarketplacePurchaseMarketplace_pending_change
{
    public function __construct(
        public ?string $effective_date = null,
        public ?int $id = null,
        public ?bool $is_installed = null,
        public ?MarketplaceListingPlan $plan = null,
        public ?int $unit_count = null,
    ) {
    }
}
