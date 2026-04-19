<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

use Acme\DigitalOcean\Generated\Enum\ApiRetrievalMethod;
use DateTimeImmutable;
use JsonSerializable;

final readonly class ApiAgentPublic implements JsonSerializable
{
    /**
     * Paogen marshal/unmarshal contract — phpName => [wireKey, shape]. See ADR-007.
     * @var array<string, array{0: string, 1: null|class-string|array{0: string, 1: null|class-string}|array{0: string, 1: list<class-string>, 2: ?string}}>
     */
    public const array PROPERTY_MAP = [
        'chatbot' => ['chatbot', \Acme\DigitalOcean\Generated\Model\ApiChatbot::class],
        'chatbot_identifiers' => [
            'chatbot_identifiers',
            ['list', \Acme\DigitalOcean\Generated\Model\ApiAgentChatbotIdentifier::class],
        ],
        'created_at' => ['created_at', ['datetime', null]],
        'deployment' => ['deployment', \Acme\DigitalOcean\Generated\Model\ApiDeployment::class],
        'description' => ['description', null],
        'if_case' => ['if_case', null],
        'instruction' => ['instruction', null],
        'k' => ['k', null],
        'max_tokens' => ['max_tokens', null],
        'model' => ['model', \Acme\DigitalOcean\Generated\Model\ApiModel::class],
        'name' => ['name', null],
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
    ];

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

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'chatbot' => $this->chatbot,
            'chatbot_identifiers' => $this->chatbot_identifiers,
            'created_at' => $this->created_at?->format(\DateTimeInterface::RFC3339),
            'deployment' => $this->deployment,
            'description' => $this->description,
            'if_case' => $this->if_case,
            'instruction' => $this->instruction,
            'k' => $this->k,
            'max_tokens' => $this->max_tokens,
            'model' => $this->model,
            'name' => $this->name,
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
        ];
    }
}
