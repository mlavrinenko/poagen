<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

final readonly class ChatCompletionRequest
{
    /**
     * @param list<\Acme\DigitalOcean\Generated\Model\ChatMessage> $messages
     * @param ?array<string, int> $logit_bias
     * @param ?array<string, string> $metadata
     * @param ?mixed $stop
     * @param ?mixed $tool_choice
     * @param ?list<\Acme\DigitalOcean\Generated\Model\ChatCompletionTool> $tools
     */
    public function __construct(
        public array $messages,
        public string $model,
        public ?float $frequency_penalty = null,
        public ?array $logit_bias = null,
        public ?bool $logprobs = null,
        public ?int $max_completion_tokens = null,
        public ?int $max_tokens = null,
        public ?array $metadata = null,
        public ?int $n = null,
        public ?float $presence_penalty = null,
        public ?string $reasoning_effort = null,
        public ?int $seed = null,
        public $stop = null,
        public ?bool $stream = null,
        public ?ChatCompletionRequestStream_options $stream_options = null,
        public ?float $temperature = null,
        public $tool_choice = null,
        public ?array $tools = null,
        public ?int $top_logprobs = null,
        public ?float $top_p = null,
        public ?string $user = null,
    ) {
    }
}
