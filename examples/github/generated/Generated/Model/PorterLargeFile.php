<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

final readonly class PorterLargeFile
{
    public function __construct(
        public string $oid,
        public string $path,
        public string $ref_name,
        public int $size,
    ) {
    }
}
