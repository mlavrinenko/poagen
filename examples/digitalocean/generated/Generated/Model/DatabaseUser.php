<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

final readonly class DatabaseUser
{
    public function __construct(
        public string $name,
        public ?string $access_cert = null,
        public ?string $access_key = null,
        public ?MysqlSettings $mysql_settings = null,
        public ?string $password = null,
        public ?string $role = null,
        public ?UserSettings $settings = null,
    ) {
    }
}
