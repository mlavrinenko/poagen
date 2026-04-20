<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

use Acme\DigitalOcean\Generated\Enum\ApiChunkingAlgorithm;

final readonly class ApiCreateKnowledgeBaseDataSourceInputPublic
{
    public function __construct(
        public ?ApiAwsdataSource $aws_data_source = null,
        public ?ApiChunkingAlgorithm $chunking_algorithm = null,
        public ?ApiChunkingOptions $chunking_options = null,
        public ?string $knowledge_base_uuid = null,
        public ?ApiSpacesDataSource $spaces_data_source = null,
        public ?ApiWebCrawlerDataSource $web_crawler_data_source = null,
    ) {
    }
}
