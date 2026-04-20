<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

final readonly class WebhookSponsorshipPendingTierChange
{
    public function __construct(
        public string $action,
        public WebhooksChanges8 $changes,
        public SimpleUser $sender,
        public WebhooksSponsorship $sponsorship,
        public ?WebhooksEffectiveDate $effective_date = null,
        public ?EnterpriseWebhooks $enterprise = null,
        public ?SimpleInstallation $installation = null,
        public ?OrganizationSimpleWebhooks $organization = null,
        public ?RepositoryWebhooks $repository = null,
    ) {
    }
}
