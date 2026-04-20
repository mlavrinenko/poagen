<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

final readonly class WebhookProjectsV2ItemEdited
{
    /**
     * @param ?mixed $changes
     */
    public function __construct(
        public string $action,
        public OrganizationSimpleWebhooks $organization,
        public ProjectsV2Item $projects_v2_item,
        public SimpleUser $sender,
        public $changes = null,
        public ?SimpleInstallation $installation = null,
    ) {
    }
}
