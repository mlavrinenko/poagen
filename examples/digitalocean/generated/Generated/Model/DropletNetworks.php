<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

use JsonSerializable;

final readonly class DropletNetworks implements JsonSerializable
{
    /**
     * Paogen marshal/unmarshal contract — phpName => [wireKey, shape]. See ADR-007.
     * @var array<string, array{0: string, 1: null|class-string|array{0: string, 1: null|class-string}|array{0: string, 1: list<class-string>, 2: ?string}}>
     */
    public const array PROPERTY_MAP = [
        'v4' => ['v4', ['list', \Acme\DigitalOcean\Generated\Model\NetworkV4::class]],
        'v6' => ['v6', ['list', \Acme\DigitalOcean\Generated\Model\NetworkV6::class]],
    ];

    /**
     * @param ?list<\Acme\DigitalOcean\Generated\Model\NetworkV4> $v4
     * @param ?list<\Acme\DigitalOcean\Generated\Model\NetworkV6> $v6
     */
    public function __construct(
        public ?array $v4 = null,
        public ?array $v6 = null,
    ) {
    }

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'v4' => $this->v4,
            'v6' => $this->v6,
        ];
    }
}
