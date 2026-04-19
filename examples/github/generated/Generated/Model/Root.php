<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

use JsonSerializable;

final readonly class Root implements JsonSerializable
{
    /**
     * Paogen marshal/unmarshal contract — phpName => [wireKey, shape]. See ADR-007.
     * @var array<string, array{0: string, 1: null|class-string|array{0: string, 1: null|class-string}|array{0: string, 1: list<class-string>, 2: ?string}}>
     */
    public const array PROPERTY_MAP = [
        'authorizations_url' => ['authorizations_url', null],
        'code_search_url' => ['code_search_url', null],
        'commit_search_url' => ['commit_search_url', null],
        'current_user_authorizations_html_url' => ['current_user_authorizations_html_url', null],
        'current_user_repositories_url' => ['current_user_repositories_url', null],
        'current_user_url' => ['current_user_url', null],
        'emails_url' => ['emails_url', null],
        'emojis_url' => ['emojis_url', null],
        'events_url' => ['events_url', null],
        'feeds_url' => ['feeds_url', null],
        'followers_url' => ['followers_url', null],
        'following_url' => ['following_url', null],
        'gists_url' => ['gists_url', null],
        'issue_search_url' => ['issue_search_url', null],
        'issues_url' => ['issues_url', null],
        'keys_url' => ['keys_url', null],
        'label_search_url' => ['label_search_url', null],
        'notifications_url' => ['notifications_url', null],
        'organization_repositories_url' => ['organization_repositories_url', null],
        'organization_teams_url' => ['organization_teams_url', null],
        'organization_url' => ['organization_url', null],
        'public_gists_url' => ['public_gists_url', null],
        'rate_limit_url' => ['rate_limit_url', null],
        'repository_search_url' => ['repository_search_url', null],
        'repository_url' => ['repository_url', null],
        'starred_gists_url' => ['starred_gists_url', null],
        'starred_url' => ['starred_url', null],
        'user_organizations_url' => ['user_organizations_url', null],
        'user_repositories_url' => ['user_repositories_url', null],
        'user_search_url' => ['user_search_url', null],
        'user_url' => ['user_url', null],
        'hub_url' => ['hub_url', null],
        'topic_search_url' => ['topic_search_url', null],
    ];

    public function __construct(
        public string $authorizations_url,
        public string $code_search_url,
        public string $commit_search_url,
        public string $current_user_authorizations_html_url,
        public string $current_user_repositories_url,
        public string $current_user_url,
        public string $emails_url,
        public string $emojis_url,
        public string $events_url,
        public string $feeds_url,
        public string $followers_url,
        public string $following_url,
        public string $gists_url,
        public string $issue_search_url,
        public string $issues_url,
        public string $keys_url,
        public string $label_search_url,
        public string $notifications_url,
        public string $organization_repositories_url,
        public string $organization_teams_url,
        public string $organization_url,
        public string $public_gists_url,
        public string $rate_limit_url,
        public string $repository_search_url,
        public string $repository_url,
        public string $starred_gists_url,
        public string $starred_url,
        public string $user_organizations_url,
        public string $user_repositories_url,
        public string $user_search_url,
        public string $user_url,
        public ?string $hub_url = null,
        public ?string $topic_search_url = null,
    ) {
    }

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'authorizations_url' => $this->authorizations_url,
            'code_search_url' => $this->code_search_url,
            'commit_search_url' => $this->commit_search_url,
            'current_user_authorizations_html_url' => $this->current_user_authorizations_html_url,
            'current_user_repositories_url' => $this->current_user_repositories_url,
            'current_user_url' => $this->current_user_url,
            'emails_url' => $this->emails_url,
            'emojis_url' => $this->emojis_url,
            'events_url' => $this->events_url,
            'feeds_url' => $this->feeds_url,
            'followers_url' => $this->followers_url,
            'following_url' => $this->following_url,
            'gists_url' => $this->gists_url,
            'issue_search_url' => $this->issue_search_url,
            'issues_url' => $this->issues_url,
            'keys_url' => $this->keys_url,
            'label_search_url' => $this->label_search_url,
            'notifications_url' => $this->notifications_url,
            'organization_repositories_url' => $this->organization_repositories_url,
            'organization_teams_url' => $this->organization_teams_url,
            'organization_url' => $this->organization_url,
            'public_gists_url' => $this->public_gists_url,
            'rate_limit_url' => $this->rate_limit_url,
            'repository_search_url' => $this->repository_search_url,
            'repository_url' => $this->repository_url,
            'starred_gists_url' => $this->starred_gists_url,
            'starred_url' => $this->starred_url,
            'user_organizations_url' => $this->user_organizations_url,
            'user_repositories_url' => $this->user_repositories_url,
            'user_search_url' => $this->user_search_url,
            'user_url' => $this->user_url,
            'hub_url' => $this->hub_url,
            'topic_search_url' => $this->topic_search_url,
        ];
    }
}
