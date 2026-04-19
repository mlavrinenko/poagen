<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

use JsonSerializable;

final readonly class ApiPrompt implements JsonSerializable
{
    /**
     * Paogen marshal/unmarshal contract — phpName => [wireKey, shape]. See ADR-007.
     * @var array<string, array{0: string, 1: null|class-string|array{0: string, 1: null|class-string}|array{0: string, 1: list<class-string>, 2: ?string}}>
     */
    public const array PROPERTY_MAP = [
        'evaluation_trace_spans' => [
            'evaluation_trace_spans',
            ['list', \Acme\DigitalOcean\Generated\Model\ApiEvaluationTraceSpan::class],
        ],
        'ground_truth' => ['ground_truth', null],
        'input' => ['input', null],
        'input_tokens' => ['input_tokens', null],
        'output' => ['output', null],
        'output_tokens' => ['output_tokens', null],
        'prompt_chunks' => ['prompt_chunks', ['list', \Acme\DigitalOcean\Generated\Model\ApiPromptChunk::class]],
        'prompt_id' => ['prompt_id', null],
        'prompt_level_metric_results' => [
            'prompt_level_metric_results',
            ['list', \Acme\DigitalOcean\Generated\Model\ApiEvaluationMetricResult::class],
        ],
        'trace_id' => ['trace_id', null],
    ];

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

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'evaluation_trace_spans' => $this->evaluation_trace_spans,
            'ground_truth' => $this->ground_truth,
            'input' => $this->input,
            'input_tokens' => $this->input_tokens,
            'output' => $this->output,
            'output_tokens' => $this->output_tokens,
            'prompt_chunks' => $this->prompt_chunks,
            'prompt_id' => $this->prompt_id,
            'prompt_level_metric_results' => $this->prompt_level_metric_results,
            'trace_id' => $this->trace_id,
        ];
    }
}
