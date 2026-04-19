<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

use JsonSerializable;

final readonly class AppFunctionsComponentHealth implements JsonSerializable
{
    /**
     * Paogen marshal/unmarshal contract — phpName => [wireKey, shape]. See ADR-007.
     * @var array<string, array{0: string, 1: null|class-string|array{0: string, 1: null|class-string}|array{0: string, 1: list<class-string>, 2: ?string}}>
     */
    public const array PROPERTY_MAP = [
        'functions_component_health_metrics' => ['functions_component_health_metrics', ['list', null]],
        'name' => ['name', null],
    ];

    /**
     * @param ?list<array<string, mixed>> $functions_component_health_metrics
     */
    public function __construct(
        public ?array $functions_component_health_metrics = null,
        public ?string $name = null,
    ) {
    }

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'functions_component_health_metrics' => $this->functions_component_health_metrics,
            'name' => $this->name,
        ];
    }
}
