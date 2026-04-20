<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

final readonly class PartnerAttachmentBgp
{
    public function __construct(
        public ?int $local_asn = null,
        public ?string $local_router_ip = null,
        public ?int $peer_asn = null,
        public ?string $peer_router_ip = null,
    ) {
    }
}
