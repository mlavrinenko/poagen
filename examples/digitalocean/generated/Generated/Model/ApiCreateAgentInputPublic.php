<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

final readonly class ApiCreateAgentInputPublic
{
    /**
     * @param ?list<string> $knowledge_base_uuid
     * @param ?list<string> $tags
     */
    public function __construct(
        public ?string $anthropic_key_uuid = null,
        public ?string $description = null,
        public ?string $instruction = null,
        public ?array $knowledge_base_uuid = null,
        public ?string $model_provider_key_uuid = null,
        public ?string $model_uuid = null,
        public ?string $name = null,
        public ?string $open_ai_key_uuid = null,
        public ?string $project_id = null,
        public ?string $region = null,
        public ?array $tags = null,
        public ?string $workspace_uuid = null,
    ) {
    }
}
