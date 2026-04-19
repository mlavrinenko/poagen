<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

use JsonSerializable;

final readonly class ModelDeploymentSpec implements JsonSerializable
{
    /**
     * Paogen marshal/unmarshal contract — phpName => [wireKey, shape]. See ADR-007.
     * @var array<string, array{0: string, 1: null|class-string|array{0: string, 1: null|class-string}|array{0: string, 1: list<class-string>, 2: ?string}}>
     */
    public const array PROPERTY_MAP = [
        'accelerators' => ['accelerators', ['list', \Acme\DigitalOcean\Generated\Model\AcceleratorConfigSpec::class]],
        'model_id' => ['model_id', null],
        'model_provider' => ['model_provider', null],
        'model_slug' => ['model_slug', null],
        'workload_config' => ['workload_config', null],
    ];

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

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'accelerators' => $this->accelerators,
            'model_id' => $this->model_id,
            'model_provider' => $this->model_provider,
            'model_slug' => $this->model_slug,
            'workload_config' => $this->workload_config,
        ];
    }
}
