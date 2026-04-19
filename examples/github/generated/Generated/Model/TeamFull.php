<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

use DateTimeImmutable;
use JsonSerializable;

final readonly class TeamFull implements JsonSerializable
{
    /**
     * Paogen marshal/unmarshal contract — phpName => [wireKey, shape]. See ADR-007.
     * @var array<string, array{0: string, 1: null|class-string|array{0: string, 1: null|class-string}|array{0: string, 1: list<class-string>, 2: ?string}}>
     */
    public const array PROPERTY_MAP = [
        'created_at' => ['created_at', ['datetime', null]],
        'description' => ['description', null],
        'html_url' => ['html_url', null],
        'id' => ['id', null],
        'members_count' => ['members_count', null],
        'members_url' => ['members_url', null],
        'name' => ['name', null],
        'node_id' => ['node_id', null],
        'organization' => ['organization', \Acme\GitHub\Generated\Model\TeamOrganization::class],
        'permission' => ['permission', null],
        'repos_count' => ['repos_count', null],
        'repositories_url' => ['repositories_url', null],
        'slug' => ['slug', null],
        'type' => ['type', null],
        'updated_at' => ['updated_at', ['datetime', null]],
        'url' => ['url', null],
        'enterprise_id' => ['enterprise_id', null],
        'ldap_dn' => ['ldap_dn', \Acme\GitHub\Generated\Model\LdapDn::class],
        'notification_setting' => ['notification_setting', null],
        'organization_id' => ['organization_id', null],
        'parent' => ['parent', \Acme\GitHub\Generated\Model\NullableTeamSimple::class],
        'privacy' => ['privacy', null],
    ];

    public function __construct(
        public DateTimeImmutable $created_at,
        public ?string $description = null,
        public string $html_url,
        public int $id,
        public int $members_count,
        public string $members_url,
        public string $name,
        public string $node_id,
        public TeamOrganization $organization,
        public string $permission,
        public int $repos_count,
        public string $repositories_url,
        public string $slug,
        public string $type,
        public DateTimeImmutable $updated_at,
        public string $url,
        public ?int $enterprise_id = null,
        public ?LdapDn $ldap_dn = null,
        public ?string $notification_setting = null,
        public ?int $organization_id = null,
        public ?NullableTeamSimple $parent = null,
        public ?string $privacy = null,
    ) {
    }

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'created_at' => $this->created_at->format(\DateTimeInterface::RFC3339),
            'description' => $this->description,
            'html_url' => $this->html_url,
            'id' => $this->id,
            'members_count' => $this->members_count,
            'members_url' => $this->members_url,
            'name' => $this->name,
            'node_id' => $this->node_id,
            'organization' => $this->organization,
            'permission' => $this->permission,
            'repos_count' => $this->repos_count,
            'repositories_url' => $this->repositories_url,
            'slug' => $this->slug,
            'type' => $this->type,
            'updated_at' => $this->updated_at->format(\DateTimeInterface::RFC3339),
            'url' => $this->url,
            'enterprise_id' => $this->enterprise_id,
            'ldap_dn' => $this->ldap_dn,
            'notification_setting' => $this->notification_setting,
            'organization_id' => $this->organization_id,
            'parent' => $this->parent,
            'privacy' => $this->privacy,
        ];
    }
}
