<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

final readonly class Feed_links
{
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
}
