<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

use JsonSerializable;

final readonly class PartnerAttachmentWritableBgp implements JsonSerializable
{
    /**
     * Paogen marshal/unmarshal contract — phpName => [wireKey, shape]. See ADR-007.
     * @var array<string, array{0: string, 1: null|class-string|array{0: string, 1: null|class-string}|array{0: string, 1: list<class-string>, 2: ?string}}>
     */
    public const array PROPERTY_MAP = [
        'auth_key' => ['auth_key', null],
        'local_router_ip' => ['local_router_ip', null],
        'peer_router_asn' => ['peer_router_asn', null],
        'peer_router_ip' => ['peer_router_ip', null],
    ];

    public function __construct(
        public string $auth_key,
        public string $local_router_ip,
        public int $peer_router_asn,
        public string $peer_router_ip,
    ) {
    }

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'auth_key' => $this->auth_key,
            'local_router_ip' => $this->local_router_ip,
            'peer_router_asn' => $this->peer_router_asn,
            'peer_router_ip' => $this->peer_router_ip,
        ];
    }
}
