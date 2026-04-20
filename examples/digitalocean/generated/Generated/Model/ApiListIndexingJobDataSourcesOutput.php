<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

final readonly class ApiListIndexingJobDataSourcesOutput
{
    /**
     * @param ?list<\Acme\DigitalOcean\Generated\Model\ApiIndexedDataSource> $indexed_data_sources
     */
    public function __construct(
        public ?array $indexed_data_sources = null,
    ) {
    }
}
