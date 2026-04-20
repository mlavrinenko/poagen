<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

final readonly class WebhookMarketplacePurchasePendingChangePrevious_marketplace_purchaseAccount
{
    public function __construct(
        public int $id,
        public string $login,
        public string $node_id,
        public ?string $organization_billing_email = null,
        public string $type,
    ) {
    }
}
