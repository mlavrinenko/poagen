<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

final readonly class ChatCompletionToolCallChunk
{
    public function __construct(
        public ?ChatCompletionToolCallChunkFunction $function = null,
        public ?string $id = null,
        public ?int $index = null,
        public ?string $type = null,
    ) {
    }
}
