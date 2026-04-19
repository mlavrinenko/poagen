<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

use JsonSerializable;

final readonly class ApiInsightsSummaryStats implements JsonSerializable
{
    /**
     * Paogen marshal/unmarshal contract — phpName => [wireKey, shape]. See ADR-007.
     * @var array<string, array{0: string, 1: null|class-string|array{0: string, 1: null|class-string}|array{0: string, 1: list<class-string>, 2: ?string}}>
     */
    public const array PROPERTY_MAP = [
        'rate_limited_request_count' => ['rate_limited_request_count', null],
        'total_request_count' => ['total_request_count', null],
    ];

    public function __construct(
        public ?int $rate_limited_request_count = null,
        public ?int $total_request_count = null,
    ) {
    }

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'rate_limited_request_count' => $this->rate_limited_request_count,
            'total_request_count' => $this->total_request_count,
        ];
    }
}
