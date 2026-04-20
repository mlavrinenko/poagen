<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

final readonly class WebhookDiscussionTransferredChanges
{
    public function __construct(
        public Discussion $new_discussion,
        public RepositoryWebhooks $new_repository,
    ) {
    }
}
