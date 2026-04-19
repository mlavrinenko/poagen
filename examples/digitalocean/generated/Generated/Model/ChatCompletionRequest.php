<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

use JsonSerializable;

final readonly class ChatCompletionRequest implements JsonSerializable
{
    /**
     * Paogen marshal/unmarshal contract — phpName => [wireKey, shape]. See ADR-007.
     * @var array<string, array{0: string, 1: null|class-string|array{0: string, 1: null|class-string}|array{0: string, 1: list<class-string>, 2: ?string}}>
     */
    public const array PROPERTY_MAP = [
        'messages' => ['messages', ['list', \Acme\DigitalOcean\Generated\Model\ChatMessage::class]],
        'model' => ['model', null],
        'frequency_penalty' => ['frequency_penalty', null],
        'logit_bias' => ['logit_bias', null],
        'logprobs' => ['logprobs', null],
        'max_completion_tokens' => ['max_completion_tokens', null],
        'max_tokens' => ['max_tokens', null],
        'metadata' => ['metadata', null],
        'n' => ['n', null],
        'presence_penalty' => ['presence_penalty', null],
        'reasoning_effort' => ['reasoning_effort', null],
        'seed' => ['seed', null],
        'stop' => ['stop', null],
        'stream' => ['stream', null],
        'stream_options' => [
            'stream_options',
            \Acme\DigitalOcean\Generated\Model\ChatCompletionRequestStream_options::class,
        ],
        'temperature' => ['temperature', null],
        'tool_choice' => ['tool_choice', null],
        'tools' => ['tools', ['list', \Acme\DigitalOcean\Generated\Model\ChatCompletionTool::class]],
        'top_logprobs' => ['top_logprobs', null],
        'top_p' => ['top_p', null],
        'user' => ['user', null],
    ];

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

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'messages' => $this->messages,
            'model' => $this->model,
            'frequency_penalty' => $this->frequency_penalty,
            'logit_bias' => $this->logit_bias,
            'logprobs' => $this->logprobs,
            'max_completion_tokens' => $this->max_completion_tokens,
            'max_tokens' => $this->max_tokens,
            'metadata' => $this->metadata,
            'n' => $this->n,
            'presence_penalty' => $this->presence_penalty,
            'reasoning_effort' => $this->reasoning_effort,
            'seed' => $this->seed,
            'stop' => $this->stop,
            'stream' => $this->stream,
            'stream_options' => $this->stream_options,
            'temperature' => $this->temperature,
            'tool_choice' => $this->tool_choice,
            'tools' => $this->tools,
            'top_logprobs' => $this->top_logprobs,
            'top_p' => $this->top_p,
            'user' => $this->user,
        ];
    }
}
