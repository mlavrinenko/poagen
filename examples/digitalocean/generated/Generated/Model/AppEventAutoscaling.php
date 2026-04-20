<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

final readonly class AppEventAutoscaling
{
    /**
     * @param ?array<string, array<string, mixed>> $components
     */
    public function __construct(
        public ?array $components = null,
        public ?string $phase = null,
    ) {
    }
}
