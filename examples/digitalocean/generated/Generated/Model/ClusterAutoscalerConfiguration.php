<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

use JsonSerializable;

final readonly class ClusterAutoscalerConfiguration implements JsonSerializable
{
    /**
     * Paogen marshal/unmarshal contract — phpName => [wireKey, shape]. See ADR-007.
     * @var array<string, array{0: string, 1: null|class-string|array{0: string, 1: null|class-string}|array{0: string, 1: list<class-string>, 2: ?string}}>
     */
    public const array PROPERTY_MAP = [
        'expanders' => ['expanders', ['list', null]],
        'scale_down_unneeded_time' => ['scale_down_unneeded_time', null],
        'scale_down_utilization_threshold' => ['scale_down_utilization_threshold', null],
    ];

    /**
     * @param ?list<string> $expanders
     */
    public function __construct(
        public ?array $expanders = null,
        public ?string $scale_down_unneeded_time = null,
        public ?float $scale_down_utilization_threshold = null,
    ) {
    }

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'expanders' => $this->expanders,
            'scale_down_unneeded_time' => $this->scale_down_unneeded_time,
            'scale_down_utilization_threshold' => $this->scale_down_utilization_threshold,
        ];
    }
}
