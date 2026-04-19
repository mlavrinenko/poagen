<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

use Acme\DigitalOcean\Generated\Enum\ApiTraceSpanType;
use DateTimeImmutable;
use JsonSerializable;

final readonly class ApiEvaluationTraceSpan implements JsonSerializable
{
    /**
     * Paogen marshal/unmarshal contract — phpName => [wireKey, shape]. See ADR-007.
     * @var array<string, array{0: string, 1: null|class-string|array{0: string, 1: null|class-string}|array{0: string, 1: list<class-string>, 2: ?string}}>
     */
    public const array PROPERTY_MAP = [
        'created_at' => ['created_at', ['datetime', null]],
        'input' => ['input', null],
        'name' => ['name', null],
        'output' => ['output', null],
        'retriever_chunks' => ['retriever_chunks', ['list', \Acme\DigitalOcean\Generated\Model\ApiPromptChunk::class]],
        'span_level_metric_results' => [
            'span_level_metric_results',
            ['list', \Acme\DigitalOcean\Generated\Model\ApiEvaluationMetricResult::class],
        ],
        'type' => ['type', ['enum', \Acme\DigitalOcean\Generated\Enum\ApiTraceSpanType::class]],
    ];

    /**
     * @param ?array<string, mixed> $input
     * @param ?array<string, mixed> $output
     * @param ?list<\Acme\DigitalOcean\Generated\Model\ApiPromptChunk> $retriever_chunks
     * @param ?list<\Acme\DigitalOcean\Generated\Model\ApiEvaluationMetricResult> $span_level_metric_results
     */
    public function __construct(
        public ?DateTimeImmutable $created_at = null,
        public ?array $input = null,
        public ?string $name = null,
        public ?array $output = null,
        public ?array $retriever_chunks = null,
        public ?array $span_level_metric_results = null,
        public ?ApiTraceSpanType $type = null,
    ) {
    }

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'created_at' => $this->created_at?->format(\DateTimeInterface::RFC3339),
            'input' => $this->input,
            'name' => $this->name,
            'output' => $this->output,
            'retriever_chunks' => $this->retriever_chunks,
            'span_level_metric_results' => $this->span_level_metric_results,
            'type' => $this->type,
        ];
    }
}
