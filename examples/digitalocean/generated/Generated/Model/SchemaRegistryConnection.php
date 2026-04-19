<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

use JsonSerializable;

final readonly class SchemaRegistryConnection implements JsonSerializable
{
    /**
     * Paogen marshal/unmarshal contract — phpName => [wireKey, shape]. See ADR-007.
     * @var array<string, array{0: string, 1: null|class-string|array{0: string, 1: null|class-string}|array{0: string, 1: list<class-string>, 2: ?string}}>
     */
    public const array PROPERTY_MAP = [
        'host' => ['host', null],
        'password' => ['password', null],
        'port' => ['port', null],
        'ssl' => ['ssl', null],
        'uri' => ['uri', null],
        'user' => ['user', null],
    ];

    public function __construct(
        public ?string $host = null,
        public ?string $password = null,
        public ?int $port = null,
        public ?bool $ssl = null,
        public ?string $uri = null,
        public ?string $user = null,
    ) {
    }

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'host' => $this->host,
            'password' => $this->password,
            'port' => $this->port,
            'ssl' => $this->ssl,
            'uri' => $this->uri,
            'user' => $this->user,
        ];
    }
}
