<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

use JsonSerializable;

final readonly class MetricsData implements JsonSerializable
{
    /**
     * Paogen marshal/unmarshal contract — phpName => [wireKey, shape]. See ADR-007.
     * @var array<string, array{0: string, 1: null|class-string|array{0: string, 1: null|class-string}|array{0: string, 1: list<class-string>, 2: ?string}}>
     */
    public const array PROPERTY_MAP = [
        'result' => ['result', ['list', \Acme\DigitalOcean\Generated\Model\MetricsResult::class]],
        'resultType' => ['resultType', null],
    ];

    /**
     * @param list<\Acme\DigitalOcean\Generated\Model\MetricsResult> $result
     */
    public function __construct(
        public array $result,
        public string $resultType,
    ) {
    }

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'result' => $this->result,
            'resultType' => $this->resultType,
        ];
    }
}
