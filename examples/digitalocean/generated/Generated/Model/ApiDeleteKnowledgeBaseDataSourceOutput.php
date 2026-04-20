<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

final readonly class ApiDeleteKnowledgeBaseDataSourceOutput
{
    public function __construct(
        public ?string $data_source_uuid = null,
        public ?string $knowledge_base_uuid = null,
    ) {
    }
}
