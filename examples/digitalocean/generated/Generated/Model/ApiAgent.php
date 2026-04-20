<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

use Acme\DigitalOcean\Generated\Enum\ApiRetrievalMethod;
use DateTimeImmutable;

final readonly class ApiAgent
{
    /**
     * @param ?list<\Acme\DigitalOcean\Generated\Model\ApiAgentApikeyInfo> $api_key_infos
     * @param ?list<\Acme\DigitalOcean\Generated\Model\ApiAgentApikey> $api_keys
     * @param ?list<\Acme\DigitalOcean\Generated\Model\ApiAgentChatbotIdentifier> $chatbot_identifiers
     * @param ?list<\Acme\DigitalOcean\Generated\Model\ApiAgent> $child_agents
     * @param ?list<\Acme\DigitalOcean\Generated\Model\ApiAgentFunction> $functions
     * @param ?list<\Acme\DigitalOcean\Generated\Model\ApiAgentGuardrail> $guardrails
     * @param ?list<\Acme\DigitalOcean\Generated\Model\ApiKnowledgeBase> $knowledge_bases
     * @param ?list<\Acme\DigitalOcean\Generated\Model\ApiAgent> $parent_agents
     * @param ?list<string> $tags
     * @param ?list<string> $vpc_egress_ips
     */
    public function __construct(
        public ?ApiAnthropicApikeyInfo $anthropic_api_key = null,
        public ?array $api_key_infos = null,
        public ?array $api_keys = null,
        public ?ApiChatbot $chatbot = null,
        public ?array $chatbot_identifiers = null,
        public ?array $child_agents = null,
        public ?bool $conversation_logs_enabled = null,
        public ?DateTimeImmutable $created_at = null,
        public ?ApiDeployment $deployment = null,
        public ?string $description = null,
        public ?array $functions = null,
        public ?array $guardrails = null,
        public ?string $if_case = null,
        public ?string $instruction = null,
        public ?int $k = null,
        public ?array $knowledge_bases = null,
        public ?ApiAgentLoggingConfig $logging_config = null,
        public ?int $max_tokens = null,
        public ?ApiModel $model = null,
        public ?ApiModelProviderKeyInfo $model_provider_key = null,
        public ?string $name = null,
        public ?ApiOpenAiapikeyInfo $openai_api_key = null,
        public ?array $parent_agents = null,
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
        public ?array $vpc_egress_ips = null,
        public ?string $vpc_uuid = null,
        public ?ApiWorkspace $workspace = null,
    ) {
    }
}
