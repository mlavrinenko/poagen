<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

use JsonSerializable;

final readonly class AppServiceSpecAutoscaling implements JsonSerializable
{
    /**
     * Paogen marshal/unmarshal contract — phpName => [wireKey, shape]. See ADR-007.
     * @var array<string, array{0: string, 1: null|class-string|array{0: string, 1: null|class-string}|array{0: string, 1: list<class-string>, 2: ?string}}>
     */
    public const array PROPERTY_MAP = [
        'max_instance_count' => ['max_instance_count', null],
        'metrics' => ['metrics', \Acme\DigitalOcean\Generated\Model\AppServiceSpecAutoscalingMetrics::class],
        'min_instance_count' => ['min_instance_count', null],
    ];

    public function __construct(
        public ?int $max_instance_count = null,
        public ?AppServiceSpecAutoscalingMetrics $metrics = null,
        public ?int $min_instance_count = null,
    ) {
    }

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'max_instance_count' => $this->max_instance_count,
            'metrics' => $this->metrics,
            'min_instance_count' => $this->min_instance_count,
        ];
    }
}
