<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

use JsonSerializable;

final readonly class PartnerAttachmentBgp implements JsonSerializable
{
    /**
     * Paogen marshal/unmarshal contract — phpName => [wireKey, shape]. See ADR-007.
     * @var array<string, array{0: string, 1: null|class-string|array{0: string, 1: null|class-string}|array{0: string, 1: list<class-string>, 2: ?string}}>
     */
    public const array PROPERTY_MAP = [
        'local_asn' => ['local_asn', null],
        'local_router_ip' => ['local_router_ip', null],
        'peer_asn' => ['peer_asn', null],
        'peer_router_ip' => ['peer_router_ip', null],
    ];

    public function __construct(
        public ?int $local_asn = null,
        public ?string $local_router_ip = null,
        public ?int $peer_asn = null,
        public ?string $peer_router_ip = null,
    ) {
    }

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'local_asn' => $this->local_asn,
            'local_router_ip' => $this->local_router_ip,
            'peer_asn' => $this->peer_asn,
            'peer_router_ip' => $this->peer_router_ip,
        ];
    }
}
