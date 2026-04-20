<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

final readonly class ImagesPostAccountTransferCreateTransferToTeam implements ImagesPostAccountTransferCreate
{
    public function __construct(
        public string $recipient_uuid,
    ) {
    }
}
