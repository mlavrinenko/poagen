<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

final readonly class PartnerAttachmentUpdatableVpcIds implements PartnerAttachmentUpdatable
{
    /**
     * @param list<string> $vpc_ids
     */
    public function __construct(
        public array $vpc_ids,
    ) {
    }
}
