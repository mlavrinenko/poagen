<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

use JsonSerializable;

final readonly class UserSettings implements JsonSerializable
{
    /**
     * Paogen marshal/unmarshal contract — phpName => [wireKey, shape]. See ADR-007.
     * @var array<string, array{0: string, 1: null|class-string|array{0: string, 1: null|class-string}|array{0: string, 1: list<class-string>, 2: ?string}}>
     */
    public const array PROPERTY_MAP = [
        'acl' => ['acl', ['list', null]],
        'mongo_user_settings' => [
            'mongo_user_settings',
            \Acme\DigitalOcean\Generated\Model\UserSettingsMongo_user_settings::class,
        ],
        'opensearch_acl' => ['opensearch_acl', ['list', null]],
        'pg_allow_replication' => ['pg_allow_replication', null],
    ];

    /**
     * @param ?list<array<string, mixed>> $acl
     * @param ?list<array<string, mixed>> $opensearch_acl
     */
    public function __construct(
        public ?array $acl = null,
        public ?UserSettingsMongo_user_settings $mongo_user_settings = null,
        public ?array $opensearch_acl = null,
        public ?bool $pg_allow_replication = null,
    ) {
    }

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'acl' => $this->acl,
            'mongo_user_settings' => $this->mongo_user_settings,
            'opensearch_acl' => $this->opensearch_acl,
            'pg_allow_replication' => $this->pg_allow_replication,
        ];
    }
}
