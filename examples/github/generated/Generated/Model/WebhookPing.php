<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

final readonly class WebhookPing
{
    public function __construct(
        public ?WebhookPingHook $hook = null,
        public ?int $hook_id = null,
        public ?OrganizationSimpleWebhooks $organization = null,
        public ?RepositoryWebhooks $repository = null,
        public ?SimpleUser $sender = null,
        public ?string $zen = null,
    ) {
    }
}
