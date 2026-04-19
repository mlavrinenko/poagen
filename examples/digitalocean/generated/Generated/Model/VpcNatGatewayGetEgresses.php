<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

use JsonSerializable;

final readonly class VpcNatGatewayGetEgresses implements JsonSerializable
{
    /**
     * Paogen marshal/unmarshal contract — phpName => [wireKey, shape]. See ADR-007.
     * @var array<string, array{0: string, 1: null|class-string|array{0: string, 1: null|class-string}|array{0: string, 1: list<class-string>, 2: ?string}}>
     */
    public const array PROPERTY_MAP = ['public_gateways' => ['public_gateways', ['list', null]]];

    /**
     * @param ?list<array<string, mixed>> $public_gateways
     */
    public function __construct(
        public ?array $public_gateways = null,
    ) {
    }

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'public_gateways' => $this->public_gateways,
        ];
    }
}
