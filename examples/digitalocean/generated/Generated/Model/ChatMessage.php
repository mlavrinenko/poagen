<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

use JsonSerializable;

final readonly class ChatMessage implements JsonSerializable
{
    /**
     * Paogen marshal/unmarshal contract — phpName => [wireKey, shape]. See ADR-007.
     * @var array<string, array{0: string, 1: null|class-string|array{0: string, 1: null|class-string}|array{0: string, 1: list<class-string>, 2: ?string}}>
     */
    public const array PROPERTY_MAP = [
        'role' => ['role', null],
        'content' => ['content', null],
        'reasoning_content' => ['reasoning_content', null],
        'refusal' => ['refusal', null],
        'tool_call_id' => ['tool_call_id', null],
        'tool_calls' => ['tool_calls', ['list', \Acme\DigitalOcean\Generated\Model\ChatCompletionToolCall::class]],
    ];

    /**
     * @param ?list<\Acme\DigitalOcean\Generated\Model\ChatCompletionToolCall> $tool_calls
     */
    public function __construct(
        public string $role,
        public ?string $content = null,
        public ?string $reasoning_content = null,
        public ?string $refusal = null,
        public ?string $tool_call_id = null,
        public ?array $tool_calls = null,
    ) {
    }

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'role' => $this->role,
            'content' => $this->content,
            'reasoning_content' => $this->reasoning_content,
            'refusal' => $this->refusal,
            'tool_call_id' => $this->tool_call_id,
            'tool_calls' => $this->tool_calls,
        ];
    }
}
