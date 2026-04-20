<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

final readonly class NullableSimpleUser
{
    public function __construct(
        public string $avatar_url,
        public string $events_url,
        public string $followers_url,
        public string $following_url,
        public string $gists_url,
        public ?string $gravatar_id = null,
        public string $html_url,
        public int $id,
        public string $login,
        public string $node_id,
        public string $organizations_url,
        public string $received_events_url,
        public string $repos_url,
        public bool $site_admin,
        public string $starred_url,
        public string $subscriptions_url,
        public string $type,
        public string $url,
        public ?string $email = null,
        public ?string $name = null,
        public ?string $starred_at = null,
        public ?string $user_view_type = null,
    ) {
    }
}
