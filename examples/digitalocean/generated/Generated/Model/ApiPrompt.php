<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

final readonly class ApiPrompt
{
    /**
     * @param ?list<\Acme\DigitalOcean\Generated\Model\ApiEvaluationTraceSpan> $evaluation_trace_spans
     * @param ?list<\Acme\DigitalOcean\Generated\Model\ApiPromptChunk> $prompt_chunks
     * @param ?list<\Acme\DigitalOcean\Generated\Model\ApiEvaluationMetricResult> $prompt_level_metric_results
     */
    public function __construct(
        public ?array $evaluation_trace_spans = null,
        public ?string $ground_truth = null,
        public ?string $input = null,
        public ?string $input_tokens = null,
        public ?string $output = null,
        public ?string $output_tokens = null,
        public ?array $prompt_chunks = null,
        public ?int $prompt_id = null,
        public ?array $prompt_level_metric_results = null,
        public ?string $trace_id = null,
    ) {
    }
}
