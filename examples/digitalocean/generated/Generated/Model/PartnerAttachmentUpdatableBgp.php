<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

final readonly class PartnerAttachmentUpdatableBgp implements PartnerAttachmentUpdatable
{
    public function __construct(
        public ?PartnerAttachmentUpdatableBgpBgp $bgp = null,
    ) {
    }
}
