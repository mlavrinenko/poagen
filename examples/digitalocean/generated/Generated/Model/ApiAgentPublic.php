<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

use Acme\DigitalOcean\Generated\Enum\ApiRetrievalMethod;
use DateTimeImmutable;

final readonly class ApiAgentPublic
{
    /**
     * @param ?list<\Acme\DigitalOcean\Generated\Model\ApiAgentChatbotIdentifier> $chatbot_identifiers
     * @param ?list<string> $tags
     */
    public function __construct(
        public ?ApiChatbot $chatbot = null,
        public ?array $chatbot_identifiers = null,
        public ?DateTimeImmutable $created_at = null,
        public ?ApiDeployment $deployment = null,
        public ?string $description = null,
        public ?string $if_case = null,
        public ?string $instruction = null,
        public ?int $k = null,
        public ?int $max_tokens = null,
        public ?ApiModel $model = null,
        public ?string $name = null,
        public ?string $project_id = null,
        public ?bool $provide_citations = null,
        public ?string $region = null,
        public ?ApiRetrievalMethod $retrieval_method = null,
        public ?DateTimeImmutable $route_created_at = null,
        public ?string $route_created_by = null,
        public ?string $route_name = null,
        public ?string $route_uuid = null,
        public ?array $tags = null,
        public ?float $temperature = null,
        public ?ApiAgentTemplate $template = null,
        public ?float $top_p = null,
        public ?DateTimeImmutable $updated_at = null,
        public ?string $url = null,
        public ?string $user_id = null,
        public ?string $uuid = null,
        public ?string $version_hash = null,
    ) {
    }
}
