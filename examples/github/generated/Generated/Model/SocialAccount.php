<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

final readonly class SocialAccount
{
    public function __construct(
        public string $provider,
        public string $url,
    ) {
    }
}
