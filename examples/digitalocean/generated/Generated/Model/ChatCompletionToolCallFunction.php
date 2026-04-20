<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

final readonly class ChatCompletionToolCallFunction
{
    public function __construct(
        public string $arguments,
        public string $name,
    ) {
    }
}
