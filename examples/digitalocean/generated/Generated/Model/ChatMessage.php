<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

final readonly class ChatMessage
{
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
}
