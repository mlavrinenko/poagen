<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

final readonly class CertificateRequestLetsEncrypt
{
    /**
     * @param list<string> $dns_names
     */
    public function __construct(
        public array $dns_names,
        public string $name,
        public ?string $type = null,
    ) {
    }
}
