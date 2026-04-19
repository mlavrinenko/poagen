<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

use JsonSerializable;

final readonly class WebhooksTeam implements JsonSerializable
{
    /**
     * Paogen marshal/unmarshal contract — phpName => [wireKey, shape]. See ADR-007.
     * @var array<string, array{0: string, 1: null|class-string|array{0: string, 1: null|class-string}|array{0: string, 1: list<class-string>, 2: ?string}}>
     */
    public const array PROPERTY_MAP = [
        'id' => ['id', null],
        'name' => ['name', null],
        'deleted' => ['deleted', null],
        'description' => ['description', null],
        'enterprise_id' => ['enterprise_id', null],
        'html_url' => ['html_url', null],
        'members_url' => ['members_url', null],
        'node_id' => ['node_id', null],
        'notification_setting' => ['notification_setting', null],
        'organization_id' => ['organization_id', null],
        'parent' => ['parent', \Acme\GitHub\Generated\Model\WebhooksTeamParent::class],
        'permission' => ['permission', null],
        'privacy' => ['privacy', null],
        'repositories_url' => ['repositories_url', null],
        'slug' => ['slug', null],
        'type' => ['type', null],
        'url' => ['url', null],
    ];

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

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'deleted' => $this->deleted,
            'description' => $this->description,
            'enterprise_id' => $this->enterprise_id,
            'html_url' => $this->html_url,
            'members_url' => $this->members_url,
            'node_id' => $this->node_id,
            'notification_setting' => $this->notification_setting,
            'organization_id' => $this->organization_id,
            'parent' => $this->parent,
            'permission' => $this->permission,
            'privacy' => $this->privacy,
            'repositories_url' => $this->repositories_url,
            'slug' => $this->slug,
            'type' => $this->type,
            'url' => $this->url,
        ];
    }
}
