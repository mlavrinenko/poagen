<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

final readonly class AppHealth
{
    /**
     * @param ?list<\Acme\DigitalOcean\Generated\Model\AppComponentHealth> $components
     * @param ?list<\Acme\DigitalOcean\Generated\Model\AppFunctionsComponentHealth> $functions_components
     */
    public function __construct(
        public ?array $components = null,
        public ?array $functions_components = null,
    ) {
    }
}
