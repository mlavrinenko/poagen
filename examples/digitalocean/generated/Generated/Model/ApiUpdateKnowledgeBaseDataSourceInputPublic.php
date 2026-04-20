<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

use Acme\DigitalOcean\Generated\Enum\ApiChunkingAlgorithm;

final readonly class ApiUpdateKnowledgeBaseDataSourceInputPublic
{
    public function __construct(
        public ?ApiChunkingAlgorithm $chunking_algorithm = null,
        public ?ApiChunkingOptions $chunking_options = null,
        public ?string $data_source_uuid = null,
        public ?string $knowledge_base_uuid = null,
    ) {
    }
}
