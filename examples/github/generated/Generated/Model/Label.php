<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

final readonly class Label
{
    public function __construct(
        public string $color,
        public bool $default,
        public ?string $description = null,
        public int $id,
        public string $name,
        public string $node_id,
        public string $url,
    ) {
    }
}
