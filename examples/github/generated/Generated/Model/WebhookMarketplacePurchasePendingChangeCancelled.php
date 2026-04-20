<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

final readonly class WebhookMarketplacePurchasePendingChangeCancelled
{
    public function __construct(
        public string $action,
        public string $effective_date,
        public WebhookMarketplacePurchasePendingChangeCancelledMarketplace_purchase $marketplace_purchase,
        public SimpleUser $sender,
        public ?EnterpriseWebhooks $enterprise = null,
        public ?SimpleInstallation $installation = null,
        public ?OrganizationSimpleWebhooks $organization = null,
        public ?WebhooksPreviousMarketplacePurchase $previous_marketplace_purchase = null,
        public ?RepositoryWebhooks $repository = null,
    ) {
    }
}
