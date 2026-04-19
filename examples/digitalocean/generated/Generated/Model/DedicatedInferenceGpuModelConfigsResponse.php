<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

use JsonSerializable;

final readonly class DedicatedInferenceGpuModelConfigsResponse implements JsonSerializable
{
    /**
     * Paogen marshal/unmarshal contract — phpName => [wireKey, shape]. See ADR-007.
     * @var array<string, array{0: string, 1: null|class-string|array{0: string, 1: null|class-string}|array{0: string, 1: list<class-string>, 2: ?string}}>
     */
    public const array PROPERTY_MAP = [
        'gpu_model_configs' => [
            'gpu_model_configs',
            ['list', \Acme\DigitalOcean\Generated\Model\DedicatedInferenceGpuModelConfig::class],
        ],
    ];

    /**
     * @param ?list<\Acme\DigitalOcean\Generated\Model\DedicatedInferenceGpuModelConfig> $gpu_model_configs
     */
    public function __construct(
        public ?array $gpu_model_configs = null,
    ) {
    }

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'gpu_model_configs' => $this->gpu_model_configs,
        ];
    }
}
