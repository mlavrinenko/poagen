<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

final readonly class ShortBlob
{
    public function __construct(
        public string $sha,
        public string $url,
    ) {
    }
}
