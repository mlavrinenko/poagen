<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

final readonly class DatabaseVersionOptions
{
    /**
     * @param ?list<string> $versions
     */
    public function __construct(
        public ?array $versions = null,
    ) {
    }
}
