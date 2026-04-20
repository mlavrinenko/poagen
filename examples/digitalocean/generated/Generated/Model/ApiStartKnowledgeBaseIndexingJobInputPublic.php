<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

final readonly class ApiStartKnowledgeBaseIndexingJobInputPublic
{
    /**
     * @param ?list<string> $data_source_uuids
     */
    public function __construct(
        public ?array $data_source_uuids = null,
        public ?string $knowledge_base_uuid = null,
    ) {
    }
}
