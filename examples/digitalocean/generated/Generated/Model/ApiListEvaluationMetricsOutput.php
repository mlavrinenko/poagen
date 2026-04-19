<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

use JsonSerializable;

final readonly class ApiListEvaluationMetricsOutput implements JsonSerializable
{
    /**
     * Paogen marshal/unmarshal contract — phpName => [wireKey, shape]. See ADR-007.
     * @var array<string, array{0: string, 1: null|class-string|array{0: string, 1: null|class-string}|array{0: string, 1: list<class-string>, 2: ?string}}>
     */
    public const array PROPERTY_MAP = [
        'metrics' => ['metrics', ['list', \Acme\DigitalOcean\Generated\Model\ApiEvaluationMetric::class]],
    ];

    /**
     * @param ?list<\Acme\DigitalOcean\Generated\Model\ApiEvaluationMetric> $metrics
     */
    public function __construct(
        public ?array $metrics = null,
    ) {
    }

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'metrics' => $this->metrics,
        ];
    }
}
