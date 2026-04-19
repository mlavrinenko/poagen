<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

use JsonSerializable;

final readonly class DedicatedInferenceGpuModelConfig implements JsonSerializable
{
    /**
     * Paogen marshal/unmarshal contract — phpName => [wireKey, shape]. See ADR-007.
     * @var array<string, array{0: string, 1: null|class-string|array{0: string, 1: null|class-string}|array{0: string, 1: list<class-string>, 2: ?string}}>
     */
    public const array PROPERTY_MAP = [
        'gpu_slugs' => ['gpu_slugs', ['list', null]],
        'is_gated_model' => ['is_gated_model', null],
        'model_name' => ['model_name', null],
        'model_slug' => ['model_slug', null],
    ];

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

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'gpu_slugs' => $this->gpu_slugs,
            'is_gated_model' => $this->is_gated_model,
            'model_name' => $this->model_name,
            'model_slug' => $this->model_slug,
        ];
    }
}
