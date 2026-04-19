<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

use JsonSerializable;

final readonly class WebhookInstallationTargetRenamedAccount implements JsonSerializable
{
    /**
     * Paogen marshal/unmarshal contract — phpName => [wireKey, shape]. See ADR-007.
     * @var array<string, array{0: string, 1: null|class-string|array{0: string, 1: null|class-string}|array{0: string, 1: list<class-string>, 2: ?string}}>
     */
    public const array PROPERTY_MAP = [
        'avatar_url' => ['avatar_url', null],
        'html_url' => ['html_url', null],
        'id' => ['id', null],
        'node_id' => ['node_id', null],
        'archived_at' => ['archived_at', null],
        'created_at' => ['created_at', null],
        'description' => ['description', null],
        'events_url' => ['events_url', null],
        'followers' => ['followers', null],
        'followers_url' => ['followers_url', null],
        'following' => ['following', null],
        'following_url' => ['following_url', null],
        'gists_url' => ['gists_url', null],
        'gravatar_id' => ['gravatar_id', null],
        'has_organization_projects' => ['has_organization_projects', null],
        'has_repository_projects' => ['has_repository_projects', null],
        'hooks_url' => ['hooks_url', null],
        'is_verified' => ['is_verified', null],
        'issues_url' => ['issues_url', null],
        'login' => ['login', null],
        'members_url' => ['members_url', null],
        'name' => ['name', null],
        'organizations_url' => ['organizations_url', null],
        'public_gists' => ['public_gists', null],
        'public_members_url' => ['public_members_url', null],
        'public_repos' => ['public_repos', null],
        'received_events_url' => ['received_events_url', null],
        'repos_url' => ['repos_url', null],
        'site_admin' => ['site_admin', null],
        'slug' => ['slug', null],
        'starred_url' => ['starred_url', null],
        'subscriptions_url' => ['subscriptions_url', null],
        'type' => ['type', null],
        'updated_at' => ['updated_at', null],
        'url' => ['url', null],
        'user_view_type' => ['user_view_type', null],
        'website_url' => ['website_url', null],
    ];

    /**
     * @param ?mixed $description
     * @param ?mixed $website_url
     */
    public function __construct(
        public string $avatar_url,
        public string $html_url,
        public int $id,
        public string $node_id,
        public ?string $archived_at = null,
        public ?string $created_at = null,
        public $description = null,
        public ?string $events_url = null,
        public ?int $followers = null,
        public ?string $followers_url = null,
        public ?int $following = null,
        public ?string $following_url = null,
        public ?string $gists_url = null,
        public ?string $gravatar_id = null,
        public ?bool $has_organization_projects = null,
        public ?bool $has_repository_projects = null,
        public ?string $hooks_url = null,
        public ?bool $is_verified = null,
        public ?string $issues_url = null,
        public ?string $login = null,
        public ?string $members_url = null,
        public ?string $name = null,
        public ?string $organizations_url = null,
        public ?int $public_gists = null,
        public ?string $public_members_url = null,
        public ?int $public_repos = null,
        public ?string $received_events_url = null,
        public ?string $repos_url = null,
        public ?bool $site_admin = null,
        public ?string $slug = null,
        public ?string $starred_url = null,
        public ?string $subscriptions_url = null,
        public ?string $type = null,
        public ?string $updated_at = null,
        public ?string $url = null,
        public ?string $user_view_type = null,
        public $website_url = null,
    ) {
    }

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'avatar_url' => $this->avatar_url,
            'html_url' => $this->html_url,
            'id' => $this->id,
            'node_id' => $this->node_id,
            'archived_at' => $this->archived_at,
            'created_at' => $this->created_at,
            'description' => $this->description,
            'events_url' => $this->events_url,
            'followers' => $this->followers,
            'followers_url' => $this->followers_url,
            'following' => $this->following,
            'following_url' => $this->following_url,
            'gists_url' => $this->gists_url,
            'gravatar_id' => $this->gravatar_id,
            'has_organization_projects' => $this->has_organization_projects,
            'has_repository_projects' => $this->has_repository_projects,
            'hooks_url' => $this->hooks_url,
            'is_verified' => $this->is_verified,
            'issues_url' => $this->issues_url,
            'login' => $this->login,
            'members_url' => $this->members_url,
            'name' => $this->name,
            'organizations_url' => $this->organizations_url,
            'public_gists' => $this->public_gists,
            'public_members_url' => $this->public_members_url,
            'public_repos' => $this->public_repos,
            'received_events_url' => $this->received_events_url,
            'repos_url' => $this->repos_url,
            'site_admin' => $this->site_admin,
            'slug' => $this->slug,
            'starred_url' => $this->starred_url,
            'subscriptions_url' => $this->subscriptions_url,
            'type' => $this->type,
            'updated_at' => $this->updated_at,
            'url' => $this->url,
            'user_view_type' => $this->user_view_type,
            'website_url' => $this->website_url,
        ];
    }
}
