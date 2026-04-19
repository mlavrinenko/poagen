<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

use JsonSerializable;

final readonly class NullableOrganizationSimple implements JsonSerializable
{
    /**
     * Paogen marshal/unmarshal contract — phpName => [wireKey, shape]. See ADR-007.
     * @var array<string, array{0: string, 1: null|class-string|array{0: string, 1: null|class-string}|array{0: string, 1: list<class-string>, 2: ?string}}>
     */
    public const array PROPERTY_MAP = [
        'avatar_url' => ['avatar_url', null],
        'description' => ['description', null],
        'events_url' => ['events_url', null],
        'hooks_url' => ['hooks_url', null],
        'id' => ['id', null],
        'issues_url' => ['issues_url', null],
        'login' => ['login', null],
        'members_url' => ['members_url', null],
        'node_id' => ['node_id', null],
        'public_members_url' => ['public_members_url', null],
        'repos_url' => ['repos_url', null],
        'url' => ['url', null],
    ];

    public function __construct(
        public string $avatar_url,
        public ?string $description = null,
        public string $events_url,
        public string $hooks_url,
        public int $id,
        public string $issues_url,
        public string $login,
        public string $members_url,
        public string $node_id,
        public string $public_members_url,
        public string $repos_url,
        public string $url,
    ) {
    }

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'avatar_url' => $this->avatar_url,
            'description' => $this->description,
            'events_url' => $this->events_url,
            'hooks_url' => $this->hooks_url,
            'id' => $this->id,
            'issues_url' => $this->issues_url,
            'login' => $this->login,
            'members_url' => $this->members_url,
            'node_id' => $this->node_id,
            'public_members_url' => $this->public_members_url,
            'repos_url' => $this->repos_url,
            'url' => $this->url,
        ];
    }
}
