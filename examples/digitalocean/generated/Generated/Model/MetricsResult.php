<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

use JsonSerializable;

final readonly class MetricsResult implements JsonSerializable
{
    /**
     * Paogen marshal/unmarshal contract — phpName => [wireKey, shape]. See ADR-007.
     * @var array<string, array{0: string, 1: null|class-string|array{0: string, 1: null|class-string}|array{0: string, 1: list<class-string>, 2: ?string}}>
     */
    public const array PROPERTY_MAP = ['metric' => ['metric', null], 'values' => ['values', ['list', null]]];

    /**
     * @param array<string, string> $metric
     * @param list<list<mixed>> $values
     */
    public function __construct(
        public array $metric,
        public array $values,
    ) {
    }

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'metric' => $this->metric,
            'values' => $this->values,
        ];
    }
}
