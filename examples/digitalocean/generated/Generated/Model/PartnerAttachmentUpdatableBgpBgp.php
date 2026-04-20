<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

final readonly class PartnerAttachmentUpdatableBgpBgp
{
    public function __construct(
        public string $auth_key,
        public string $local_router_ip,
        public int $peer_router_asn,
        public string $peer_router_ip,
    ) {
    }
}
