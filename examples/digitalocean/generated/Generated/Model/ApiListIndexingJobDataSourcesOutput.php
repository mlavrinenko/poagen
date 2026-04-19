<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

use JsonSerializable;

final readonly class ApiListIndexingJobDataSourcesOutput implements JsonSerializable
{
    /**
     * Paogen marshal/unmarshal contract — phpName => [wireKey, shape]. See ADR-007.
     * @var array<string, array{0: string, 1: null|class-string|array{0: string, 1: null|class-string}|array{0: string, 1: list<class-string>, 2: ?string}}>
     */
    public const array PROPERTY_MAP = [
        'indexed_data_sources' => [
            'indexed_data_sources',
            ['list', \Acme\DigitalOcean\Generated\Model\ApiIndexedDataSource::class],
        ],
    ];

    /**
     * @param ?list<\Acme\DigitalOcean\Generated\Model\ApiIndexedDataSource> $indexed_data_sources
     */
    public function __construct(
        public ?array $indexed_data_sources = null,
    ) {
    }

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'indexed_data_sources' => $this->indexed_data_sources,
        ];
    }
}
