<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

final readonly class WebhookRepositoryEditedChanges
{
    public function __construct(
        public ?WebhookRepositoryEditedChangesDefault_branch $default_branch = null,
        public ?WebhookRepositoryEditedChangesDescription $description = null,
        public ?WebhookRepositoryEditedChangesHomepage $homepage = null,
        public ?WebhookRepositoryEditedChangesTopics $topics = null,
    ) {
    }
}
