<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

use Acme\DigitalOcean\Generated\Enum\ApiAgentTemplateType;
use DateTimeImmutable;
use JsonSerializable;

final readonly class ApiAgentTemplate implements JsonSerializable
{
    /**
     * Paogen marshal/unmarshal contract — phpName => [wireKey, shape]. See ADR-007.
     * @var array<string, array{0: string, 1: null|class-string|array{0: string, 1: null|class-string}|array{0: string, 1: list<class-string>, 2: ?string}}>
     */
    public const array PROPERTY_MAP = [
        'created_at' => ['created_at', ['datetime', null]],
        'description' => ['description', null],
        'guardrails' => ['guardrails', ['list', \Acme\DigitalOcean\Generated\Model\ApiAgentTemplateGuardrail::class]],
        'instruction' => ['instruction', null],
        'k' => ['k', null],
        'knowledge_bases' => ['knowledge_bases', ['list', \Acme\DigitalOcean\Generated\Model\ApiKnowledgeBase::class]],
        'long_description' => ['long_description', null],
        'max_tokens' => ['max_tokens', null],
        'model' => ['model', \Acme\DigitalOcean\Generated\Model\ApiModel::class],
        'name' => ['name', null],
        'short_description' => ['short_description', null],
        'summary' => ['summary', null],
        'tags' => ['tags', ['list', null]],
        'temperature' => ['temperature', null],
        'template_type' => ['template_type', ['enum', \Acme\DigitalOcean\Generated\Enum\ApiAgentTemplateType::class]],
        'top_p' => ['top_p', null],
        'updated_at' => ['updated_at', ['datetime', null]],
        'uuid' => ['uuid', null],
    ];

    /**
     * @param ?list<\Acme\DigitalOcean\Generated\Model\ApiAgentTemplateGuardrail> $guardrails
     * @param ?list<\Acme\DigitalOcean\Generated\Model\ApiKnowledgeBase> $knowledge_bases
     * @param ?list<string> $tags
     */
    public function __construct(
        public ?DateTimeImmutable $created_at = null,
        public ?string $description = null,
        public ?array $guardrails = null,
        public ?string $instruction = null,
        public ?int $k = null,
        public ?array $knowledge_bases = null,
        public ?string $long_description = null,
        public ?int $max_tokens = null,
        public ?ApiModel $model = null,
        public ?string $name = null,
        public ?string $short_description = null,
        public ?string $summary = null,
        public ?array $tags = null,
        public ?float $temperature = null,
        public ?ApiAgentTemplateType $template_type = null,
        public ?float $top_p = null,
        public ?DateTimeImmutable $updated_at = null,
        public ?string $uuid = null,
    ) {
    }

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'created_at' => $this->created_at?->format(\DateTimeInterface::RFC3339),
            'description' => $this->description,
            'guardrails' => $this->guardrails,
            'instruction' => $this->instruction,
            'k' => $this->k,
            'knowledge_bases' => $this->knowledge_bases,
            'long_description' => $this->long_description,
            'max_tokens' => $this->max_tokens,
            'model' => $this->model,
            'name' => $this->name,
            'short_description' => $this->short_description,
            'summary' => $this->summary,
            'tags' => $this->tags,
            'temperature' => $this->temperature,
            'template_type' => $this->template_type,
            'top_p' => $this->top_p,
            'updated_at' => $this->updated_at?->format(\DateTimeInterface::RFC3339),
            'uuid' => $this->uuid,
        ];
    }
}
