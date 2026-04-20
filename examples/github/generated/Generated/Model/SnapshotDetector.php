<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

final readonly class SnapshotDetector
{
    public function __construct(
        public string $name,
        public string $url,
        public string $version,
    ) {
    }
}
