<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

final readonly class WebhookDeploymentStatusCreatedDeployment_statusPerformed_via_github_appOwner
{
    public function __construct(
        public int $id,
        public string $login,
        public ?string $avatar_url = null,
        public ?bool $deleted = null,
        public ?string $email = null,
        public ?string $events_url = null,
        public ?string $followers_url = null,
        public ?string $following_url = null,
        public ?string $gists_url = null,
        public ?string $gravatar_id = null,
        public ?string $html_url = null,
        public ?string $name = null,
        public ?string $node_id = null,
        public ?string $organizations_url = null,
        public ?string $received_events_url = null,
        public ?string $repos_url = null,
        public ?bool $site_admin = null,
        public ?string $starred_url = null,
        public ?string $subscriptions_url = null,
        public ?string $type = null,
        public ?string $url = null,
        public ?string $user_view_type = null,
    ) {
    }
}
