<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

final readonly class CertificateRequestCustom
{
    public function __construct(
        public string $leaf_certificate,
        public string $name,
        public string $private_key,
        public ?string $certificate_chain = null,
        public ?string $type = null,
    ) {
    }
}
