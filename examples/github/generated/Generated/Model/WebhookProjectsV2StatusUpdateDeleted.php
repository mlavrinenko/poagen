<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

final readonly class WebhookProjectsV2StatusUpdateDeleted
{
    public function __construct(
        public string $action,
        public OrganizationSimpleWebhooks $organization,
        public ProjectsV2StatusUpdate $projects_v2_status_update,
        public SimpleUser $sender,
        public ?SimpleInstallation $installation = null,
    ) {
    }
}
