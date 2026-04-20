<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

final readonly class ApiCreateKnowledgeBaseInputPublic
{
    /**
     * @param ?list<\Acme\DigitalOcean\Generated\Model\ApiKbdataSource> $datasources
     * @param ?list<string> $tags
     */
    public function __construct(
        public ?string $database_id = null,
        public ?array $datasources = null,
        public ?string $embedding_model_uuid = null,
        public ?string $name = null,
        public ?string $project_id = null,
        public ?string $region = null,
        public ?array $tags = null,
        public ?string $vpc_uuid = null,
    ) {
    }
}
