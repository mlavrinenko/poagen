<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

use JsonSerializable;

final readonly class ControlPlaneFirewall implements JsonSerializable
{
    /**
     * Paogen marshal/unmarshal contract — phpName => [wireKey, shape]. See ADR-007.
     * @var array<string, array{0: string, 1: null|class-string|array{0: string, 1: null|class-string}|array{0: string, 1: list<class-string>, 2: ?string}}>
     */
    public const array PROPERTY_MAP = [
        'allowed_addresses' => ['allowed_addresses', ['list', null]],
        'enabled' => ['enabled', null],
    ];

    /**
     * @param ?list<string> $allowed_addresses
     */
    public function __construct(
        public ?array $allowed_addresses = null,
        public ?bool $enabled = null,
    ) {
    }

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'allowed_addresses' => $this->allowed_addresses,
            'enabled' => $this->enabled,
        ];
    }
}
