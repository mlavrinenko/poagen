<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

final readonly class AppsRestartRequest
{
    /**
     * @param ?list<string> $components
     */
    public function __construct(
        public ?array $components = null,
    ) {
    }
}
