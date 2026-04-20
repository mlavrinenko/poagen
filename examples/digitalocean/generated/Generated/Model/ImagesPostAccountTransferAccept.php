<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

final readonly class ImagesPostAccountTransferAccept
{
    public function __construct(
        public string $recipient_uuid,
        public int $transfer_id,
    ) {
    }
}
