<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

use JsonSerializable;

final readonly class ElasticsearchLogsink implements JsonSerializable
{
    /**
     * Paogen marshal/unmarshal contract — phpName => [wireKey, shape]. See ADR-007.
     * @var array<string, array{0: string, 1: null|class-string|array{0: string, 1: null|class-string}|array{0: string, 1: list<class-string>, 2: ?string}}>
     */
    public const array PROPERTY_MAP = [
        'index_prefix' => ['index_prefix', null],
        'url' => ['url', null],
        'ca' => ['ca', null],
        'index_days_max' => ['index_days_max', null],
        'timeout' => ['timeout', null],
    ];

    public function __construct(
        public string $index_prefix,
        public string $url,
        public ?string $ca = null,
        public ?int $index_days_max = null,
        public ?float $timeout = null,
    ) {
    }

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'index_prefix' => $this->index_prefix,
            'url' => $this->url,
            'ca' => $this->ca,
            'index_days_max' => $this->index_days_max,
            'timeout' => $this->timeout,
        ];
    }
}
