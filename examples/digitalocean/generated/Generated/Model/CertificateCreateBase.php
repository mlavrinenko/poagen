<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

final readonly class CertificateCreateBase
{
    public function __construct(
        public string $name,
        public ?string $type = null,
    ) {
    }
}
