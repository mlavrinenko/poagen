<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

final readonly class CodespacesUserPublicKey
{
    public function __construct(
        public string $key,
        public string $key_id,
    ) {
    }
}
