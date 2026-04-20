<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

use DateTimeImmutable;

final readonly class PartnerAttachmentServiceKey
{
    public function __construct(
        public ?DateTimeImmutable $created_at = null,
        public ?string $state = null,
        public ?string $value = null,
    ) {
    }
}
