<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

final readonly class WebhookMilestoneEditedChanges
{
    public function __construct(
        public ?WebhookMilestoneEditedChangesDescription $description = null,
        public ?WebhookMilestoneEditedChangesDue_on $due_on = null,
        public ?WebhookMilestoneEditedChangesTitle $title = null,
    ) {
    }
}
