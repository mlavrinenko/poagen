<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

final readonly class ApiOverviewSsh_key_fingerprints
{
    public function __construct(
        public ?string $SHA256_DSA = null,
        public ?string $SHA256_ECDSA = null,
        public ?string $SHA256_ED25519 = null,
        public ?string $SHA256_RSA = null,
    ) {
    }
}
