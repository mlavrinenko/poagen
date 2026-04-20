<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

final readonly class DatabaseLayoutOptions
{
    /**
     * @param ?list<\Acme\DigitalOcean\Generated\Model\DatabaseLayoutOption> $layouts
     */
    public function __construct(
        public ?array $layouts = null,
    ) {
    }
}
