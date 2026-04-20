<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

use Acme\DigitalOcean\Generated\Enum\ApiAgentTemplateType;
use DateTimeImmutable;

final readonly class ApiAgentTemplate
{
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
}
