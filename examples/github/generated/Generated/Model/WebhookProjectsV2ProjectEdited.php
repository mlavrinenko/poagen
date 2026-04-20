<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

final readonly class WebhookProjectsV2ProjectEdited
{
    public function __construct(
        public string $action,
        public WebhookProjectsV2ProjectEditedChanges $changes,
        public OrganizationSimpleWebhooks $organization,
        public ProjectsV2 $projects_v2,
        public SimpleUser $sender,
        public ?SimpleInstallation $installation = null,
    ) {
    }
}
