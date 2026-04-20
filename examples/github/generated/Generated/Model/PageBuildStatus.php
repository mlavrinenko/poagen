<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

final readonly class PageBuildStatus
{
    public function __construct(
        public string $status,
        public string $url,
    ) {
    }
}
