<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

final readonly class Check
{
    /**
     * @param ?list<string> $regions
     */
    public function __construct(
        public ?bool $enabled = null,
        public ?string $id = null,
        public ?string $name = null,
        public ?array $regions = null,
        public ?string $target = null,
        public ?string $type = null,
    ) {
    }
}
