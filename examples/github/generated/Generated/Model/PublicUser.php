<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

use DateTimeImmutable;
use JsonSerializable;

final readonly class PublicUser implements JsonSerializable
{
    /**
     * Paogen marshal/unmarshal contract — phpName => [wireKey, shape]. See ADR-007.
     * @var array<string, array{0: string, 1: null|class-string|array{0: string, 1: null|class-string}|array{0: string, 1: list<class-string>, 2: ?string}}>
     */
    public const array PROPERTY_MAP = [
        'avatar_url' => ['avatar_url', null],
        'bio' => ['bio', null],
        'blog' => ['blog', null],
        'company' => ['company', null],
        'created_at' => ['created_at', ['datetime', null]],
        'email' => ['email', null],
        'events_url' => ['events_url', null],
        'followers' => ['followers', null],
        'followers_url' => ['followers_url', null],
        'following' => ['following', null],
        'following_url' => ['following_url', null],
        'gists_url' => ['gists_url', null],
        'gravatar_id' => ['gravatar_id', null],
        'hireable' => ['hireable', null],
        'html_url' => ['html_url', null],
        'id' => ['id', null],
        'location' => ['location', null],
        'login' => ['login', null],
        'name' => ['name', null],
        'node_id' => ['node_id', null],
        'organizations_url' => ['organizations_url', null],
        'public_gists' => ['public_gists', null],
        'public_repos' => ['public_repos', null],
        'received_events_url' => ['received_events_url', null],
        'repos_url' => ['repos_url', null],
        'site_admin' => ['site_admin', null],
        'starred_url' => ['starred_url', null],
        'subscriptions_url' => ['subscriptions_url', null],
        'type' => ['type', null],
        'updated_at' => ['updated_at', ['datetime', null]],
        'url' => ['url', null],
        'collaborators' => ['collaborators', null],
        'disk_usage' => ['disk_usage', null],
        'notification_email' => ['notification_email', null],
        'owned_private_repos' => ['owned_private_repos', null],
        'plan' => ['plan', \Acme\GitHub\Generated\Model\PublicUserPlan::class],
        'private_gists' => ['private_gists', null],
        'total_private_repos' => ['total_private_repos', null],
        'twitter_username' => ['twitter_username', null],
        'user_view_type' => ['user_view_type', null],
    ];

    public function __construct(
        public string $avatar_url,
        public ?string $bio = null,
        public ?string $blog = null,
        public ?string $company = null,
        public DateTimeImmutable $created_at,
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
        public int $public_gists,
        public int $public_repos,
        public string $received_events_url,
        public string $repos_url,
        public bool $site_admin,
        public string $starred_url,
        public string $subscriptions_url,
        public string $type,
        public DateTimeImmutable $updated_at,
        public string $url,
        public ?int $collaborators = null,
        public ?int $disk_usage = null,
        public ?string $notification_email = null,
        public ?int $owned_private_repos = null,
        public ?PublicUserPlan $plan = null,
        public ?int $private_gists = null,
        public ?int $total_private_repos = null,
        public ?string $twitter_username = null,
        public ?string $user_view_type = null,
    ) {
    }

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'avatar_url' => $this->avatar_url,
            'bio' => $this->bio,
            'blog' => $this->blog,
            'company' => $this->company,
            'created_at' => $this->created_at->format(\DateTimeInterface::RFC3339),
            'email' => $this->email,
            'events_url' => $this->events_url,
            'followers' => $this->followers,
            'followers_url' => $this->followers_url,
            'following' => $this->following,
            'following_url' => $this->following_url,
            'gists_url' => $this->gists_url,
            'gravatar_id' => $this->gravatar_id,
            'hireable' => $this->hireable,
            'html_url' => $this->html_url,
            'id' => $this->id,
            'location' => $this->location,
            'login' => $this->login,
            'name' => $this->name,
            'node_id' => $this->node_id,
            'organizations_url' => $this->organizations_url,
            'public_gists' => $this->public_gists,
            'public_repos' => $this->public_repos,
            'received_events_url' => $this->received_events_url,
            'repos_url' => $this->repos_url,
            'site_admin' => $this->site_admin,
            'starred_url' => $this->starred_url,
            'subscriptions_url' => $this->subscriptions_url,
            'type' => $this->type,
            'updated_at' => $this->updated_at->format(\DateTimeInterface::RFC3339),
            'url' => $this->url,
            'collaborators' => $this->collaborators,
            'disk_usage' => $this->disk_usage,
            'notification_email' => $this->notification_email,
            'owned_private_repos' => $this->owned_private_repos,
            'plan' => $this->plan,
            'private_gists' => $this->private_gists,
            'total_private_repos' => $this->total_private_repos,
            'twitter_username' => $this->twitter_username,
            'user_view_type' => $this->user_view_type,
        ];
    }
}
