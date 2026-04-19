<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

use JsonSerializable;

final readonly class ReservedIpv6List implements JsonSerializable
{
    /**
     * Paogen marshal/unmarshal contract — phpName => [wireKey, shape]. See ADR-007.
     * @var array<string, array{0: string, 1: null|class-string|array{0: string, 1: null|class-string}|array{0: string, 1: list<class-string>, 2: ?string}}>
     */
    public const array PROPERTY_MAP = ['reserved_ipv6s' => ['reserved_ipv6s', ['list', null]]];

    /**
     * @param ?list<mixed> $reserved_ipv6s
     */
    public function __construct(
        public ?array $reserved_ipv6s = null,
    ) {
    }

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'reserved_ipv6s' => $this->reserved_ipv6s,
        ];
    }
}
