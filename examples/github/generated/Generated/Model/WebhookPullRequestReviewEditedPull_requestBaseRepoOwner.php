<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

use JsonSerializable;

final readonly class WebhookPullRequestReviewEditedPull_requestBaseRepoOwner implements JsonSerializable
{
    /**
     * Paogen marshal/unmarshal contract — phpName => [wireKey, shape]. See ADR-007.
     * @var array<string, array{0: string, 1: null|class-string|array{0: string, 1: null|class-string}|array{0: string, 1: list<class-string>, 2: ?string}}>
     */
    public const array PROPERTY_MAP = [
        'id' => ['id', null],
        'login' => ['login', null],
        'avatar_url' => ['avatar_url', null],
        'deleted' => ['deleted', null],
        'email' => ['email', null],
        'events_url' => ['events_url', null],
        'followers_url' => ['followers_url', null],
        'following_url' => ['following_url', null],
        'gists_url' => ['gists_url', null],
        'gravatar_id' => ['gravatar_id', null],
        'html_url' => ['html_url', null],
        'name' => ['name', null],
        'node_id' => ['node_id', null],
        'organizations_url' => ['organizations_url', null],
        'received_events_url' => ['received_events_url', null],
        'repos_url' => ['repos_url', null],
        'site_admin' => ['site_admin', null],
        'starred_url' => ['starred_url', null],
        'subscriptions_url' => ['subscriptions_url', null],
        'type' => ['type', null],
        'url' => ['url', null],
        'user_view_type' => ['user_view_type', null],
    ];

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

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'id' => $this->id,
            'login' => $this->login,
            'avatar_url' => $this->avatar_url,
            'deleted' => $this->deleted,
            'email' => $this->email,
            'events_url' => $this->events_url,
            'followers_url' => $this->followers_url,
            'following_url' => $this->following_url,
            'gists_url' => $this->gists_url,
            'gravatar_id' => $this->gravatar_id,
            'html_url' => $this->html_url,
            'name' => $this->name,
            'node_id' => $this->node_id,
            'organizations_url' => $this->organizations_url,
            'received_events_url' => $this->received_events_url,
            'repos_url' => $this->repos_url,
            'site_admin' => $this->site_admin,
            'starred_url' => $this->starred_url,
            'subscriptions_url' => $this->subscriptions_url,
            'type' => $this->type,
            'url' => $this->url,
            'user_view_type' => $this->user_view_type,
        ];
    }
}
