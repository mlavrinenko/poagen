<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

final readonly class AppsDomainProgress
{
    /**
     * @param ?list<array<string, mixed>> $steps
     */
    public function __construct(
        public ?array $steps = null,
    ) {
    }
}
