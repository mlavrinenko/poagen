<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

use JsonSerializable;

final readonly class ConnectionPools implements JsonSerializable
{
    /**
     * Paogen marshal/unmarshal contract — phpName => [wireKey, shape]. See ADR-007.
     * @var array<string, array{0: string, 1: null|class-string|array{0: string, 1: null|class-string}|array{0: string, 1: list<class-string>, 2: ?string}}>
     */
    public const array PROPERTY_MAP = [
        'pools' => ['pools', ['list', \Acme\DigitalOcean\Generated\Model\ConnectionPool::class]],
    ];

    /**
     * @param ?list<\Acme\DigitalOcean\Generated\Model\ConnectionPool> $pools
     */
    public function __construct(
        public ?array $pools = null,
    ) {
    }

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'pools' => $this->pools,
        ];
    }
}
