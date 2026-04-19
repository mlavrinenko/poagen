<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

use JsonSerializable;

final readonly class ChatCompletionStreamResponseDelta implements JsonSerializable
{
    /**
     * Paogen marshal/unmarshal contract — phpName => [wireKey, shape]. See ADR-007.
     * @var array<string, array{0: string, 1: null|class-string|array{0: string, 1: null|class-string}|array{0: string, 1: list<class-string>, 2: ?string}}>
     */
    public const array PROPERTY_MAP = [
        'content' => ['content', null],
        'reasoning_content' => ['reasoning_content', null],
        'refusal' => ['refusal', null],
        'role' => ['role', null],
        'tool_calls' => ['tool_calls', ['list', \Acme\DigitalOcean\Generated\Model\ChatCompletionToolCallChunk::class]],
    ];

    /**
     * @param ?list<\Acme\DigitalOcean\Generated\Model\ChatCompletionToolCallChunk> $tool_calls
     */
    public function __construct(
        public ?string $content = null,
        public ?string $reasoning_content = null,
        public ?string $refusal = null,
        public ?string $role = null,
        public ?array $tool_calls = null,
    ) {
    }

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'content' => $this->content,
            'reasoning_content' => $this->reasoning_content,
            'refusal' => $this->refusal,
            'role' => $this->role,
            'tool_calls' => $this->tool_calls,
        ];
    }
}
