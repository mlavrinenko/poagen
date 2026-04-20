<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

final readonly class AppFunctionsComponentHealth
{
    /**
     * @param ?list<array<string, mixed>> $functions_component_health_metrics
     */
    public function __construct(
        public ?array $functions_component_health_metrics = null,
        public ?string $name = null,
    ) {
    }
}
