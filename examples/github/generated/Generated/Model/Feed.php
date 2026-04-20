<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

final readonly class Feed
{
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
}
