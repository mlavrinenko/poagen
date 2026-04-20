<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

final readonly class DedicatedInferenceGpuModelConfigsResponse
{
    /**
     * @param ?list<\Acme\DigitalOcean\Generated\Model\DedicatedInferenceGpuModelConfig> $gpu_model_configs
     */
    public function __construct(
        public ?array $gpu_model_configs = null,
    ) {
    }
}
