<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

final readonly class Region
{
    /**
     * @param list<string> $features
     * @param list<string> $sizes
     */
    public function __construct(
        public bool $available,
        public array $features,
        public string $name,
        public array $sizes,
        public string $slug,
    ) {
    }
}
