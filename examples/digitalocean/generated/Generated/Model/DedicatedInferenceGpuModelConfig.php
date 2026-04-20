<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

final readonly class DedicatedInferenceGpuModelConfig
{
    /**
     * @param ?list<string> $gpu_slugs
     */
    public function __construct(
        public ?array $gpu_slugs = null,
        public ?bool $is_gated_model = null,
        public ?string $model_name = null,
        public ?string $model_slug = null,
    ) {
    }
}
