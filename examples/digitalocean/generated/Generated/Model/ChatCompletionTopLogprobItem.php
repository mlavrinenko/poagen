<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

final readonly class ChatCompletionTopLogprobItem
{
    /**
     * @param ?list<int> $bytes
     */
    public function __construct(
        public ?array $bytes = null,
        public float $logprob,
        public string $token,
    ) {
    }
}
