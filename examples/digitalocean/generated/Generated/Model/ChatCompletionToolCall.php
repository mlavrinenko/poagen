<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

final readonly class ChatCompletionToolCall
{
    public function __construct(
        public ChatCompletionToolCallFunction $function,
        public string $id,
        public string $type,
    ) {
    }
}
