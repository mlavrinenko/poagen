<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

final readonly class WebhookSponsorshipEdited
{
    public function __construct(
        public string $action,
        public WebhookSponsorshipEditedChanges $changes,
        public SimpleUser $sender,
        public WebhooksSponsorship $sponsorship,
        public ?EnterpriseWebhooks $enterprise = null,
        public ?SimpleInstallation $installation = null,
        public ?OrganizationSimpleWebhooks $organization = null,
        public ?RepositoryWebhooks $repository = null,
    ) {
    }
}
