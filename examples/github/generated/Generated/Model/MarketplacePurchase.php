<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

final readonly class MarketplacePurchase
{
    public function __construct(
        public int $id,
        public string $login,
        public MarketplacePurchaseMarketplace_purchase $marketplace_purchase,
        public string $type,
        public string $url,
        public ?string $email = null,
        public ?MarketplacePurchaseMarketplace_pending_change $marketplace_pending_change = null,
        public ?string $organization_billing_email = null,
    ) {
    }
}
