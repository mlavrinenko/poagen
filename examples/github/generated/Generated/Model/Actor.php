<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

final readonly class Actor
{
    public function __construct(
        public string $avatar_url,
        public ?string $gravatar_id = null,
        public int $id,
        public string $login,
        public string $url,
        public ?string $display_login = null,
    ) {
    }
}
