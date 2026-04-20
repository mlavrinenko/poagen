<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

final readonly class ModelDeploymentSpec
{
    /**
     * @param ?list<\Acme\DigitalOcean\Generated\Model\AcceleratorConfigSpec> $accelerators
     * @param ?array<string, mixed> $workload_config
     */
    public function __construct(
        public ?array $accelerators = null,
        public ?string $model_id = null,
        public ?string $model_provider = null,
        public ?string $model_slug = null,
        public ?array $workload_config = null,
    ) {
    }
}
