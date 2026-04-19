<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

use JsonSerializable;

final readonly class RateLimitOverview implements JsonSerializable
{
    /**
     * Paogen marshal/unmarshal contract — phpName => [wireKey, shape]. See ADR-007.
     * @var array<string, array{0: string, 1: null|class-string|array{0: string, 1: null|class-string}|array{0: string, 1: list<class-string>, 2: ?string}}>
     */
    public const array PROPERTY_MAP = [
        'rate' => ['rate', \Acme\GitHub\Generated\Model\RateLimit::class],
        'resources' => ['resources', \Acme\GitHub\Generated\Model\RateLimitOverviewResources::class],
    ];

    public function __construct(
        public RateLimit $rate,
        public RateLimitOverviewResources $resources,
    ) {
    }

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'rate' => $this->rate,
            'resources' => $this->resources,
        ];
    }
}
