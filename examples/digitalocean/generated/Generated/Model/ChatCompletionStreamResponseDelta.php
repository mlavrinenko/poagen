<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

final readonly class ChatCompletionStreamResponseDelta
{
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
}
