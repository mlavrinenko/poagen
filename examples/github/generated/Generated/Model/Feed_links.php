<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

use JsonSerializable;

final readonly class Feed_links implements JsonSerializable
{
    /**
     * Paogen marshal/unmarshal contract — phpName => [wireKey, shape]. See ADR-007.
     * @var array<string, array{0: string, 1: null|class-string|array{0: string, 1: null|class-string}|array{0: string, 1: list<class-string>, 2: ?string}}>
     */
    public const array PROPERTY_MAP = [
        'timeline' => ['timeline', \Acme\GitHub\Generated\Model\LinkWithType::class],
        'user' => ['user', \Acme\GitHub\Generated\Model\LinkWithType::class],
        'current_user' => ['current_user', \Acme\GitHub\Generated\Model\LinkWithType::class],
        'current_user_actor' => ['current_user_actor', \Acme\GitHub\Generated\Model\LinkWithType::class],
        'current_user_organization' => ['current_user_organization', \Acme\GitHub\Generated\Model\LinkWithType::class],
        'current_user_organizations' => [
            'current_user_organizations',
            ['list', \Acme\GitHub\Generated\Model\LinkWithType::class],
        ],
        'current_user_public' => ['current_user_public', \Acme\GitHub\Generated\Model\LinkWithType::class],
        'repository_discussions' => ['repository_discussions', \Acme\GitHub\Generated\Model\LinkWithType::class],
        'repository_discussions_category' => [
            'repository_discussions_category',
            \Acme\GitHub\Generated\Model\LinkWithType::class,
        ],
        'security_advisories' => ['security_advisories', \Acme\GitHub\Generated\Model\LinkWithType::class],
    ];

    /**
     * @param ?list<\Acme\GitHub\Generated\Model\LinkWithType> $current_user_organizations
     */
    public function __construct(
        public LinkWithType $timeline,
        public LinkWithType $user,
        public ?LinkWithType $current_user = null,
        public ?LinkWithType $current_user_actor = null,
        public ?LinkWithType $current_user_organization = null,
        public ?array $current_user_organizations = null,
        public ?LinkWithType $current_user_public = null,
        public ?LinkWithType $repository_discussions = null,
        public ?LinkWithType $repository_discussions_category = null,
        public ?LinkWithType $security_advisories = null,
    ) {
    }

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'timeline' => $this->timeline,
            'user' => $this->user,
            'current_user' => $this->current_user,
            'current_user_actor' => $this->current_user_actor,
            'current_user_organization' => $this->current_user_organization,
            'current_user_organizations' => $this->current_user_organizations,
            'current_user_public' => $this->current_user_public,
            'repository_discussions' => $this->repository_discussions,
            'repository_discussions_category' => $this->repository_discussions_category,
            'security_advisories' => $this->security_advisories,
        ];
    }
}
