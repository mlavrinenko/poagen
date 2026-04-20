<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

final readonly class WebhooksMembership
{
    /**
     * @param ?list<string> $enterprise_teams_providing_indirect_membership
     */
    public function __construct(
        public string $organization_url,
        public string $role,
        public string $state,
        public string $url,
        public WebhooksMembershipUser $user,
        public ?bool $direct_membership = null,
        public ?array $enterprise_teams_providing_indirect_membership = null,
    ) {
    }
}
