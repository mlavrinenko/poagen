<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

use JsonSerializable;

final readonly class WebhooksTeamParent implements JsonSerializable
{
    /**
     * Paogen marshal/unmarshal contract — phpName => [wireKey, shape]. See ADR-007.
     * @var array<string, array{0: string, 1: null|class-string|array{0: string, 1: null|class-string}|array{0: string, 1: list<class-string>, 2: ?string}}>
     */
    public const array PROPERTY_MAP = [
        'description' => ['description', null],
        'html_url' => ['html_url', null],
        'id' => ['id', null],
        'members_url' => ['members_url', null],
        'name' => ['name', null],
        'node_id' => ['node_id', null],
        'notification_setting' => ['notification_setting', null],
        'permission' => ['permission', null],
        'privacy' => ['privacy', null],
        'repositories_url' => ['repositories_url', null],
        'slug' => ['slug', null],
        'type' => ['type', null],
        'url' => ['url', null],
        'enterprise_id' => ['enterprise_id', null],
        'organization_id' => ['organization_id', null],
    ];

    public function __construct(
        public ?string $description = null,
        public string $html_url,
        public int $id,
        public string $members_url,
        public string $name,
        public string $node_id,
        public string $notification_setting,
        public string $permission,
        public string $privacy,
        public string $repositories_url,
        public string $slug,
        public string $type,
        public string $url,
        public ?int $enterprise_id = null,
        public ?int $organization_id = null,
    ) {
    }

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'description' => $this->description,
            'html_url' => $this->html_url,
            'id' => $this->id,
            'members_url' => $this->members_url,
            'name' => $this->name,
            'node_id' => $this->node_id,
            'notification_setting' => $this->notification_setting,
            'permission' => $this->permission,
            'privacy' => $this->privacy,
            'repositories_url' => $this->repositories_url,
            'slug' => $this->slug,
            'type' => $this->type,
            'url' => $this->url,
            'enterprise_id' => $this->enterprise_id,
            'organization_id' => $this->organization_id,
        ];
    }
}
