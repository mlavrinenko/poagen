<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

final readonly class ChatCompletionTokenLogprob
{
    /**
     * @param ?list<int> $bytes
     * @param list<\Acme\DigitalOcean\Generated\Model\ChatCompletionTopLogprobItem> $top_logprobs
     */
    public function __construct(
        public ?array $bytes = null,
        public float $logprob,
        public string $token,
        public array $top_logprobs,
    ) {
    }
}
