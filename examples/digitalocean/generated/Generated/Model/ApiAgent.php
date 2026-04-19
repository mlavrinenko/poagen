<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

use Acme\DigitalOcean\Generated\Enum\ApiRetrievalMethod;
use DateTimeImmutable;
use JsonSerializable;

final readonly class ApiAgent implements JsonSerializable
{
    /**
     * Paogen marshal/unmarshal contract — phpName => [wireKey, shape]. See ADR-007.
     * @var array<string, array{0: string, 1: null|class-string|array{0: string, 1: null|class-string}|array{0: string, 1: list<class-string>, 2: ?string}}>
     */
    public const array PROPERTY_MAP = [
        'anthropic_api_key' => ['anthropic_api_key', \Acme\DigitalOcean\Generated\Model\ApiAnthropicApikeyInfo::class],
        'api_key_infos' => ['api_key_infos', ['list', \Acme\DigitalOcean\Generated\Model\ApiAgentApikeyInfo::class]],
        'api_keys' => ['api_keys', ['list', \Acme\DigitalOcean\Generated\Model\ApiAgentApikey::class]],
        'chatbot' => ['chatbot', \Acme\DigitalOcean\Generated\Model\ApiChatbot::class],
        'chatbot_identifiers' => [
            'chatbot_identifiers',
            ['list', \Acme\DigitalOcean\Generated\Model\ApiAgentChatbotIdentifier::class],
        ],
        'child_agents' => ['child_agents', ['list', \Acme\DigitalOcean\Generated\Model\ApiAgent::class]],
        'conversation_logs_enabled' => ['conversation_logs_enabled', null],
        'created_at' => ['created_at', ['datetime', null]],
        'deployment' => ['deployment', \Acme\DigitalOcean\Generated\Model\ApiDeployment::class],
        'description' => ['description', null],
        'functions' => ['functions', ['list', \Acme\DigitalOcean\Generated\Model\ApiAgentFunction::class]],
        'guardrails' => ['guardrails', ['list', \Acme\DigitalOcean\Generated\Model\ApiAgentGuardrail::class]],
        'if_case' => ['if_case', null],
        'instruction' => ['instruction', null],
        'k' => ['k', null],
        'knowledge_bases' => ['knowledge_bases', ['list', \Acme\DigitalOcean\Generated\Model\ApiKnowledgeBase::class]],
        'logging_config' => ['logging_config', \Acme\DigitalOcean\Generated\Model\ApiAgentLoggingConfig::class],
        'max_tokens' => ['max_tokens', null],
        'model' => ['model', \Acme\DigitalOcean\Generated\Model\ApiModel::class],
        'model_provider_key' => ['model_provider_key', \Acme\DigitalOcean\Generated\Model\ApiModelProviderKeyInfo::class],
        'name' => ['name', null],
        'openai_api_key' => ['openai_api_key', \Acme\DigitalOcean\Generated\Model\ApiOpenAiapikeyInfo::class],
        'parent_agents' => ['parent_agents', ['list', \Acme\DigitalOcean\Generated\Model\ApiAgent::class]],
        'project_id' => ['project_id', null],
        'provide_citations' => ['provide_citations', null],
        'region' => ['region', null],
        'retrieval_method' => ['retrieval_method', ['enum', \Acme\DigitalOcean\Generated\Enum\ApiRetrievalMethod::class]],
        'route_created_at' => ['route_created_at', ['datetime', null]],
        'route_created_by' => ['route_created_by', null],
        'route_name' => ['route_name', null],
        'route_uuid' => ['route_uuid', null],
        'tags' => ['tags', ['list', null]],
        'temperature' => ['temperature', null],
        'template' => ['template', \Acme\DigitalOcean\Generated\Model\ApiAgentTemplate::class],
        'top_p' => ['top_p', null],
        'updated_at' => ['updated_at', ['datetime', null]],
        'url' => ['url', null],
        'user_id' => ['user_id', null],
        'uuid' => ['uuid', null],
        'version_hash' => ['version_hash', null],
        'vpc_egress_ips' => ['vpc_egress_ips', ['list', null]],
        'vpc_uuid' => ['vpc_uuid', null],
        'workspace' => ['workspace', \Acme\DigitalOcean\Generated\Model\ApiWorkspace::class],
    ];

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

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'anthropic_api_key' => $this->anthropic_api_key,
            'api_key_infos' => $this->api_key_infos,
            'api_keys' => $this->api_keys,
            'chatbot' => $this->chatbot,
            'chatbot_identifiers' => $this->chatbot_identifiers,
            'child_agents' => $this->child_agents,
            'conversation_logs_enabled' => $this->conversation_logs_enabled,
            'created_at' => $this->created_at?->format(\DateTimeInterface::RFC3339),
            'deployment' => $this->deployment,
            'description' => $this->description,
            'functions' => $this->functions,
            'guardrails' => $this->guardrails,
            'if_case' => $this->if_case,
            'instruction' => $this->instruction,
            'k' => $this->k,
            'knowledge_bases' => $this->knowledge_bases,
            'logging_config' => $this->logging_config,
            'max_tokens' => $this->max_tokens,
            'model' => $this->model,
            'model_provider_key' => $this->model_provider_key,
            'name' => $this->name,
            'openai_api_key' => $this->openai_api_key,
            'parent_agents' => $this->parent_agents,
            'project_id' => $this->project_id,
            'provide_citations' => $this->provide_citations,
            'region' => $this->region,
            'retrieval_method' => $this->retrieval_method,
            'route_created_at' => $this->route_created_at?->format(\DateTimeInterface::RFC3339),
            'route_created_by' => $this->route_created_by,
            'route_name' => $this->route_name,
            'route_uuid' => $this->route_uuid,
            'tags' => $this->tags,
            'temperature' => $this->temperature,
            'template' => $this->template,
            'top_p' => $this->top_p,
            'updated_at' => $this->updated_at?->format(\DateTimeInterface::RFC3339),
            'url' => $this->url,
            'user_id' => $this->user_id,
            'uuid' => $this->uuid,
            'version_hash' => $this->version_hash,
            'vpc_egress_ips' => $this->vpc_egress_ips,
            'vpc_uuid' => $this->vpc_uuid,
            'workspace' => $this->workspace,
        ];
    }
}
