<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

final readonly class UserSettings
{
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
}
