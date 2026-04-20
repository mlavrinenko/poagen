<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

use Acme\DigitalOcean\Generated\Enum\ApiTraceSpanType;
use DateTimeImmutable;

final readonly class ApiEvaluationTraceSpan
{
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
}
