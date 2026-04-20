<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

final readonly class CodespacesPublicKey
{
    public function __construct(
        public string $key,
        public string $key_id,
        public ?string $created_at = null,
        public ?int $id = null,
        public ?string $title = null,
        public ?string $url = null,
    ) {
    }
}
