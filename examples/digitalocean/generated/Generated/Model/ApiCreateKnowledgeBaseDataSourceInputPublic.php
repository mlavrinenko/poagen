<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

use Acme\DigitalOcean\Generated\Enum\ApiChunkingAlgorithm;
use JsonSerializable;

final readonly class ApiCreateKnowledgeBaseDataSourceInputPublic implements JsonSerializable
{
    /**
     * Paogen marshal/unmarshal contract — phpName => [wireKey, shape]. See ADR-007.
     * @var array<string, array{0: string, 1: null|class-string|array{0: string, 1: null|class-string}|array{0: string, 1: list<class-string>, 2: ?string}}>
     */
    public const array PROPERTY_MAP = [
        'aws_data_source' => ['aws_data_source', \Acme\DigitalOcean\Generated\Model\ApiAwsdataSource::class],
        'chunking_algorithm' => [
            'chunking_algorithm',
            ['enum', \Acme\DigitalOcean\Generated\Enum\ApiChunkingAlgorithm::class],
        ],
        'chunking_options' => ['chunking_options', \Acme\DigitalOcean\Generated\Model\ApiChunkingOptions::class],
        'knowledge_base_uuid' => ['knowledge_base_uuid', null],
        'spaces_data_source' => ['spaces_data_source', \Acme\DigitalOcean\Generated\Model\ApiSpacesDataSource::class],
        'web_crawler_data_source' => [
            'web_crawler_data_source',
            \Acme\DigitalOcean\Generated\Model\ApiWebCrawlerDataSource::class,
        ],
    ];

    public function __construct(
        public ?ApiAwsdataSource $aws_data_source = null,
        public ?ApiChunkingAlgorithm $chunking_algorithm = null,
        public ?ApiChunkingOptions $chunking_options = null,
        public ?string $knowledge_base_uuid = null,
        public ?ApiSpacesDataSource $spaces_data_source = null,
        public ?ApiWebCrawlerDataSource $web_crawler_data_source = null,
    ) {
    }

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'aws_data_source' => $this->aws_data_source,
            'chunking_algorithm' => $this->chunking_algorithm,
            'chunking_options' => $this->chunking_options,
            'knowledge_base_uuid' => $this->knowledge_base_uuid,
            'spaces_data_source' => $this->spaces_data_source,
            'web_crawler_data_source' => $this->web_crawler_data_source,
        ];
    }
}
