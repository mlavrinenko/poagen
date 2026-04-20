<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

final readonly class ContentTraffic
{
    public function __construct(
        public int $count,
        public string $path,
        public string $title,
        public int $uniques,
    ) {
    }
}
