<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

final readonly class WebhookDiscussionUnanswered
{
    public function __construct(
        public string $action,
        public Discussion $discussion,
        public WebhooksAnswer $old_answer,
        public RepositoryWebhooks $repository,
        public ?OrganizationSimpleWebhooks $organization = null,
        public ?SimpleUser $sender = null,
    ) {
    }
}
