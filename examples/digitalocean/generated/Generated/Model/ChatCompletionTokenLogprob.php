<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

use JsonSerializable;

final readonly class ChatCompletionTokenLogprob implements JsonSerializable
{
    /**
     * Paogen marshal/unmarshal contract — phpName => [wireKey, shape]. See ADR-007.
     * @var array<string, array{0: string, 1: null|class-string|array{0: string, 1: null|class-string}|array{0: string, 1: list<class-string>, 2: ?string}}>
     */
    public const array PROPERTY_MAP = [
        'bytes' => ['bytes', ['list', null]],
        'logprob' => ['logprob', null],
        'token' => ['token', null],
        'top_logprobs' => [
            'top_logprobs',
            ['list', \Acme\DigitalOcean\Generated\Model\ChatCompletionTopLogprobItem::class],
        ],
    ];

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

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'bytes' => $this->bytes,
            'logprob' => $this->logprob,
            'token' => $this->token,
            'top_logprobs' => $this->top_logprobs,
        ];
    }
}
