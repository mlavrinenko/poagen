<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

use JsonSerializable;

final readonly class Feed implements JsonSerializable
{
    /**
     * Paogen marshal/unmarshal contract — phpName => [wireKey, shape]. See ADR-007.
     * @var array<string, array{0: string, 1: null|class-string|array{0: string, 1: null|class-string}|array{0: string, 1: list<class-string>, 2: ?string}}>
     */
    public const array PROPERTY_MAP = [
        '_links' => ['_links', \Acme\GitHub\Generated\Model\Feed_links::class],
        'timeline_url' => ['timeline_url', null],
        'user_url' => ['user_url', null],
        'current_user_actor_url' => ['current_user_actor_url', null],
        'current_user_organization_url' => ['current_user_organization_url', null],
        'current_user_organization_urls' => ['current_user_organization_urls', ['list', null]],
        'current_user_public_url' => ['current_user_public_url', null],
        'current_user_url' => ['current_user_url', null],
        'repository_discussions_category_url' => ['repository_discussions_category_url', null],
        'repository_discussions_url' => ['repository_discussions_url', null],
        'security_advisories_url' => ['security_advisories_url', null],
    ];

    /**
     * @param ?list<string> $current_user_organization_urls
     */
    public function __construct(
        public Feed_links $_links,
        public string $timeline_url,
        public string $user_url,
        public ?string $current_user_actor_url = null,
        public ?string $current_user_organization_url = null,
        public ?array $current_user_organization_urls = null,
        public ?string $current_user_public_url = null,
        public ?string $current_user_url = null,
        public ?string $repository_discussions_category_url = null,
        public ?string $repository_discussions_url = null,
        public ?string $security_advisories_url = null,
    ) {
    }

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            '_links' => $this->_links,
            'timeline_url' => $this->timeline_url,
            'user_url' => $this->user_url,
            'current_user_actor_url' => $this->current_user_actor_url,
            'current_user_organization_url' => $this->current_user_organization_url,
            'current_user_organization_urls' => $this->current_user_organization_urls,
            'current_user_public_url' => $this->current_user_public_url,
            'current_user_url' => $this->current_user_url,
            'repository_discussions_category_url' => $this->repository_discussions_category_url,
            'repository_discussions_url' => $this->repository_discussions_url,
            'security_advisories_url' => $this->security_advisories_url,
        ];
    }
}
