<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

use JsonSerializable;

final readonly class DatabaseUser implements JsonSerializable
{
    /**
     * Paogen marshal/unmarshal contract — phpName => [wireKey, shape]. See ADR-007.
     * @var array<string, array{0: string, 1: null|class-string|array{0: string, 1: null|class-string}|array{0: string, 1: list<class-string>, 2: ?string}}>
     */
    public const array PROPERTY_MAP = [
        'name' => ['name', null],
        'access_cert' => ['access_cert', null],
        'access_key' => ['access_key', null],
        'mysql_settings' => ['mysql_settings', \Acme\DigitalOcean\Generated\Model\MysqlSettings::class],
        'password' => ['password', null],
        'role' => ['role', null],
        'settings' => ['settings', \Acme\DigitalOcean\Generated\Model\UserSettings::class],
    ];

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

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'name' => $this->name,
            'access_cert' => $this->access_cert,
            'access_key' => $this->access_key,
            'mysql_settings' => $this->mysql_settings,
            'password' => $this->password,
            'role' => $this->role,
            'settings' => $this->settings,
        ];
    }
}
