<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

use DateTimeImmutable;

final readonly class Credentials
{
    public function __construct(
        public ?string $certificate_authority_data = null,
        public ?string $client_certificate_data = null,
        public ?string $client_key_data = null,
        public ?DateTimeImmutable $expires_at = null,
        public ?string $server = null,
        public ?string $token = null,
    ) {
    }
}
