<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

use DateTimeImmutable;
use JsonSerializable;

final readonly class UserSearchResultItem implements JsonSerializable
{
    /**
     * Paogen marshal/unmarshal contract — phpName => [wireKey, shape]. See ADR-007.
     * @var array<string, array{0: string, 1: null|class-string|array{0: string, 1: null|class-string}|array{0: string, 1: list<class-string>, 2: ?string}}>
     */
    public const array PROPERTY_MAP = [
        'avatar_url' => ['avatar_url', null],
        'events_url' => ['events_url', null],
        'followers_url' => ['followers_url', null],
        'following_url' => ['following_url', null],
        'gists_url' => ['gists_url', null],
        'gravatar_id' => ['gravatar_id', null],
        'html_url' => ['html_url', null],
        'id' => ['id', null],
        'login' => ['login', null],
        'node_id' => ['node_id', null],
        'organizations_url' => ['organizations_url', null],
        'received_events_url' => ['received_events_url', null],
        'repos_url' => ['repos_url', null],
        'score' => ['score', null],
        'site_admin' => ['site_admin', null],
        'starred_url' => ['starred_url', null],
        'subscriptions_url' => ['subscriptions_url', null],
        'type' => ['type', null],
        'url' => ['url', null],
        'bio' => ['bio', null],
        'blog' => ['blog', null],
        'company' => ['company', null],
        'created_at' => ['created_at', ['datetime', null]],
        'email' => ['email', null],
        'followers' => ['followers', null],
        'following' => ['following', null],
        'hireable' => ['hireable', null],
        'location' => ['location', null],
        'name' => ['name', null],
        'public_gists' => ['public_gists', null],
        'public_repos' => ['public_repos', null],
        'suspended_at' => ['suspended_at', ['datetime', null]],
        'text_matches' => ['text_matches', \Acme\GitHub\Generated\Model\SearchResultTextMatches::class],
        'updated_at' => ['updated_at', ['datetime', null]],
        'user_view_type' => ['user_view_type', null],
    ];

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
        public float $score,
        public bool $site_admin,
        public string $starred_url,
        public string $subscriptions_url,
        public string $type,
        public string $url,
        public ?string $bio = null,
        public ?string $blog = null,
        public ?string $company = null,
        public ?DateTimeImmutable $created_at = null,
        public ?string $email = null,
        public ?int $followers = null,
        public ?int $following = null,
        public ?bool $hireable = null,
        public ?string $location = null,
        public ?string $name = null,
        public ?int $public_gists = null,
        public ?int $public_repos = null,
        public ?DateTimeImmutable $suspended_at = null,
        public ?SearchResultTextMatches $text_matches = null,
        public ?DateTimeImmutable $updated_at = null,
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
            'events_url' => $this->events_url,
            'followers_url' => $this->followers_url,
            'following_url' => $this->following_url,
            'gists_url' => $this->gists_url,
            'gravatar_id' => $this->gravatar_id,
            'html_url' => $this->html_url,
            'id' => $this->id,
            'login' => $this->login,
            'node_id' => $this->node_id,
            'organizations_url' => $this->organizations_url,
            'received_events_url' => $this->received_events_url,
            'repos_url' => $this->repos_url,
            'score' => $this->score,
            'site_admin' => $this->site_admin,
            'starred_url' => $this->starred_url,
            'subscriptions_url' => $this->subscriptions_url,
            'type' => $this->type,
            'url' => $this->url,
            'bio' => $this->bio,
            'blog' => $this->blog,
            'company' => $this->company,
            'created_at' => $this->created_at?->format(\DateTimeInterface::RFC3339),
            'email' => $this->email,
            'followers' => $this->followers,
            'following' => $this->following,
            'hireable' => $this->hireable,
            'location' => $this->location,
            'name' => $this->name,
            'public_gists' => $this->public_gists,
            'public_repos' => $this->public_repos,
            'suspended_at' => $this->suspended_at?->format(\DateTimeInterface::RFC3339),
            'text_matches' => $this->text_matches,
            'updated_at' => $this->updated_at?->format(\DateTimeInterface::RFC3339),
            'user_view_type' => $this->user_view_type,
        ];
    }
}
