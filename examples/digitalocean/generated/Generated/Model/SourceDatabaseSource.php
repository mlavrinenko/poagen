<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

use JsonSerializable;

final readonly class SourceDatabaseSource implements JsonSerializable
{
    /**
     * Paogen marshal/unmarshal contract — phpName => [wireKey, shape]. See ADR-007.
     * @var array<string, array{0: string, 1: null|class-string|array{0: string, 1: null|class-string}|array{0: string, 1: list<class-string>, 2: ?string}}>
     */
    public const array PROPERTY_MAP = [
        'dbname' => ['dbname', null],
        'host' => ['host', null],
        'password' => ['password', null],
        'port' => ['port', null],
        'username' => ['username', null],
    ];

    public function __construct(
        public ?string $dbname = null,
        public ?string $host = null,
        public ?string $password = null,
        public ?int $port = null,
        public ?string $username = null,
    ) {
    }

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'dbname' => $this->dbname,
            'host' => $this->host,
            'password' => $this->password,
            'port' => $this->port,
            'username' => $this->username,
        ];
    }
}
