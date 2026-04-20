<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

final readonly class WebhookCreate
{
    public function __construct(
        public ?string $description = null,
        public string $master_branch,
        public WebhooksDeployPusherType $pusher_type,
        public WebhooksRef0 $ref,
        public string $ref_type,
        public RepositoryWebhooks $repository,
        public SimpleUser $sender,
        public ?EnterpriseWebhooks $enterprise = null,
        public ?SimpleInstallation $installation = null,
        public ?OrganizationSimpleWebhooks $organization = null,
    ) {
    }
}
