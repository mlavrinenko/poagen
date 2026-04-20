<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

final readonly class WebhooksTeam
{
    public function __construct(
        public int $id,
        public string $name,
        public ?bool $deleted = null,
        public ?string $description = null,
        public ?int $enterprise_id = null,
        public ?string $html_url = null,
        public ?string $members_url = null,
        public ?string $node_id = null,
        public ?string $notification_setting = null,
        public ?int $organization_id = null,
        public ?WebhooksTeamParent $parent = null,
        public ?string $permission = null,
        public ?string $privacy = null,
        public ?string $repositories_url = null,
        public ?string $slug = null,
        public ?string $type = null,
        public ?string $url = null,
    ) {
    }
}
