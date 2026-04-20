<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

final readonly class WebhookTeamEditedChanges
{
    public function __construct(
        public ?WebhookTeamEditedChangesDescription $description = null,
        public ?WebhookTeamEditedChangesName $name = null,
        public ?WebhookTeamEditedChangesNotification_setting $notification_setting = null,
        public ?WebhookTeamEditedChangesPrivacy $privacy = null,
        public ?WebhookTeamEditedChangesRepository $repository = null,
    ) {
    }
}
