<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

final readonly class WebhookMarketplacePurchaseChanged
{
    public function __construct(
        public string $action,
        public string $effective_date,
        public WebhooksMarketplacePurchase $marketplace_purchase,
        public SimpleUser $sender,
        public ?EnterpriseWebhooks $enterprise = null,
        public ?SimpleInstallation $installation = null,
        public ?OrganizationSimpleWebhooks $organization = null,
        public ?WebhookMarketplacePurchaseChangedPrevious_marketplace_purchase $previous_marketplace_purchase = null,
        public ?RepositoryWebhooks $repository = null,
    ) {
    }
}
