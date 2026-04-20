<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

use DateTimeImmutable;

final readonly class PrivateUser
{
    public function __construct(
        public string $avatar_url,
        public ?string $bio = null,
        public ?string $blog = null,
        public int $collaborators,
        public ?string $company = null,
        public DateTimeImmutable $created_at,
        public int $disk_usage,
        public ?string $email = null,
        public string $events_url,
        public int $followers,
        public string $followers_url,
        public int $following,
        public string $following_url,
        public string $gists_url,
        public ?string $gravatar_id = null,
        public ?bool $hireable = null,
        public string $html_url,
        public int $id,
        public ?string $location = null,
        public string $login,
        public ?string $name = null,
        public string $node_id,
        public string $organizations_url,
        public int $owned_private_repos,
        public int $private_gists,
        public int $public_gists,
        public int $public_repos,
        public string $received_events_url,
        public string $repos_url,
        public bool $site_admin,
        public string $starred_url,
        public string $subscriptions_url,
        public int $total_private_repos,
        public bool $two_factor_authentication,
        public string $type,
        public DateTimeImmutable $updated_at,
        public string $url,
        public ?bool $business_plus = null,
        public ?string $ldap_dn = null,
        public ?string $notification_email = null,
        public ?PrivateUserPlan $plan = null,
        public ?string $twitter_username = null,
        public ?string $user_view_type = null,
    ) {
    }
}
