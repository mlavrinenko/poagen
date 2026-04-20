<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

final readonly class ApiListKnowledgeBaseDataSourcesOutput
{
    /**
     * @param ?list<\Acme\DigitalOcean\Generated\Model\ApiKnowledgeBaseDataSource> $knowledge_base_data_sources
     */
    public function __construct(
        public ?array $knowledge_base_data_sources = null,
        public ?ApiLinks $links = null,
        public ?ApiMeta $meta = null,
    ) {
    }
}
