<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

final readonly class WebhookPush
{
    /**
     * @param list<array<string, mixed>> $commits
     */
    public function __construct(
        public string $after,
        public WebhooksNullableString $base_ref,
        public string $before,
        public array $commits,
        public string $compare,
        public bool $created,
        public bool $deleted,
        public bool $forced,
        public WebhookPushHead_commit $head_commit,
        public WebhookPushPusher $pusher,
        public string $ref,
        public WebhookPushRepository $repository,
        public ?EnterpriseWebhooks $enterprise = null,
        public ?SimpleInstallation $installation = null,
        public ?OrganizationSimpleWebhooks $organization = null,
        public ?SimpleUser $sender = null,
    ) {
    }
}
