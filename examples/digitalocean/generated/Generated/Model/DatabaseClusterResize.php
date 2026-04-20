<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

final readonly class DatabaseClusterResize
{
    public function __construct(
        public int $num_nodes,
        public string $size,
        public ?int $storage_size_mib = null,
    ) {
    }
}
