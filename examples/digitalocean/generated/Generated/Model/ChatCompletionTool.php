<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

final readonly class ChatCompletionTool
{
    public function __construct(
        public FunctionObject $function,
        public string $type,
    ) {
    }
}
