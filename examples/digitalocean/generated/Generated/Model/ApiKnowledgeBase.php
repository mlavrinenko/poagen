<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

use DateTimeImmutable;

final readonly class ApiKnowledgeBase
{
    /**
     * @param ?list<string> $tags
     */
    public function __construct(
        public ?DateTimeImmutable $added_to_agent_at = null,
        public ?DateTimeImmutable $created_at = null,
        public ?string $database_id = null,
        public ?string $embedding_model_uuid = null,
        public ?bool $is_public = null,
        public ?ApiIndexingJob $last_indexing_job = null,
        public ?string $name = null,
        public ?string $project_id = null,
        public ?string $region = null,
        public ?array $tags = null,
        public ?DateTimeImmutable $updated_at = null,
        public ?string $user_id = null,
        public ?string $uuid = null,
    ) {
    }
}
