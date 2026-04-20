<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

final readonly class WebhookProjectsV2ItemReordered
{
    public function __construct(
        public string $action,
        public WebhookProjectsV2ItemReorderedChanges $changes,
        public OrganizationSimpleWebhooks $organization,
        public ProjectsV2Item $projects_v2_item,
        public SimpleUser $sender,
        public ?SimpleInstallation $installation = null,
    ) {
    }
}
