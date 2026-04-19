<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

use JsonSerializable;

final readonly class NetworkV6 implements JsonSerializable
{
    /**
     * Paogen marshal/unmarshal contract — phpName => [wireKey, shape]. See ADR-007.
     * @var array<string, array{0: string, 1: null|class-string|array{0: string, 1: null|class-string}|array{0: string, 1: list<class-string>, 2: ?string}}>
     */
    public const array PROPERTY_MAP = [
        'gateway' => ['gateway', null],
        'ip_address' => ['ip_address', null],
        'netmask' => ['netmask', null],
        'type' => ['type', null],
    ];

    public function __construct(
        public ?string $gateway = null,
        public ?string $ip_address = null,
        public ?int $netmask = null,
        public ?string $type = null,
    ) {
    }

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'gateway' => $this->gateway,
            'ip_address' => $this->ip_address,
            'netmask' => $this->netmask,
            'type' => $this->type,
        ];
    }
}
