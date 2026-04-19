<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

use JsonSerializable;

final readonly class CreateResponseRequest implements JsonSerializable
{
    /**
     * Paogen marshal/unmarshal contract — phpName => [wireKey, shape]. See ADR-007.
     * @var array<string, array{0: string, 1: null|class-string|array{0: string, 1: null|class-string}|array{0: string, 1: list<class-string>, 2: ?string}}>
     */
    public const array PROPERTY_MAP = [
        'input' => ['input', null],
        'model' => ['model', null],
        'instructions' => ['instructions', null],
        'max_output_tokens' => ['max_output_tokens', null],
        'metadata' => ['metadata', null],
        'stop' => ['stop', null],
        'stream' => ['stream', null],
        'stream_options' => [
            'stream_options',
            \Acme\DigitalOcean\Generated\Model\CreateResponseRequestStream_options::class,
        ],
        'temperature' => ['temperature', null],
        'tool_choice' => ['tool_choice', null],
        'tools' => ['tools', ['list', null]],
        'top_p' => ['top_p', null],
        'user' => ['user', null],
    ];

    /**
     * @param mixed $input
     * @param ?array<string, string> $metadata
     * @param ?mixed $stop
     * @param ?mixed $tool_choice
     * @param ?list<array<string, mixed>> $tools
     */
    public function __construct(
        public $input,
        public string $model,
        public ?string $instructions = null,
        public ?int $max_output_tokens = null,
        public ?array $metadata = null,
        public $stop = null,
        public ?bool $stream = null,
        public ?CreateResponseRequestStream_options $stream_options = null,
        public ?float $temperature = null,
        public $tool_choice = null,
        public ?array $tools = null,
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
            'input' => $this->input,
            'model' => $this->model,
            'instructions' => $this->instructions,
            'max_output_tokens' => $this->max_output_tokens,
            'metadata' => $this->metadata,
            'stop' => $this->stop,
            'stream' => $this->stream,
            'stream_options' => $this->stream_options,
            'temperature' => $this->temperature,
            'tool_choice' => $this->tool_choice,
            'tools' => $this->tools,
            'top_p' => $this->top_p,
            'user' => $this->user,
        ];
    }
}
