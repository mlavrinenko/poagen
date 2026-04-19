<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

use JsonSerializable;

final readonly class ConnectionPool implements JsonSerializable
{
    /**
     * Paogen marshal/unmarshal contract — phpName => [wireKey, shape]. See ADR-007.
     * @var array<string, array{0: string, 1: null|class-string|array{0: string, 1: null|class-string}|array{0: string, 1: list<class-string>, 2: ?string}}>
     */
    public const array PROPERTY_MAP = [
        'db' => ['db', null],
        'mode' => ['mode', null],
        'name' => ['name', null],
        'size' => ['size', null],
        'connection' => ['connection', null],
        'private_connection' => ['private_connection', null],
        'standby_connection' => ['standby_connection', null],
        'standby_private_connection' => ['standby_private_connection', null],
        'user' => ['user', null],
    ];

    /**
     * @param ?mixed $connection
     * @param ?mixed $private_connection
     * @param ?mixed $standby_connection
     * @param ?mixed $standby_private_connection
     */
    public function __construct(
        public string $db,
        public string $mode,
        public string $name,
        public int $size,
        public $connection = null,
        public $private_connection = null,
        public $standby_connection = null,
        public $standby_private_connection = null,
        public ?string $user = null,
    ) {
    }

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'db' => $this->db,
            'mode' => $this->mode,
            'name' => $this->name,
            'size' => $this->size,
            'connection' => $this->connection,
            'private_connection' => $this->private_connection,
            'standby_connection' => $this->standby_connection,
            'standby_private_connection' => $this->standby_private_connection,
            'user' => $this->user,
        ];
    }
}
