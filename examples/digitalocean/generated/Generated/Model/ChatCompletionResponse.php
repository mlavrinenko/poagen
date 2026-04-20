<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

final readonly class ChatCompletionResponse
{
    /**
     * @param list<array<string, mixed>> $choices
     */
    public function __construct(
        public array $choices,
        public int $created,
        public string $id,
        public string $model,
        public string $object,
        public ?CompletionUsage $usage = null,
    ) {
    }
}
