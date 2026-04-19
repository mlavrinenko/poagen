<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

use JsonSerializable;

final readonly class CompletionUsage implements JsonSerializable
{
    /**
     * Paogen marshal/unmarshal contract — phpName => [wireKey, shape]. See ADR-007.
     * @var array<string, array{0: string, 1: null|class-string|array{0: string, 1: null|class-string}|array{0: string, 1: list<class-string>, 2: ?string}}>
     */
    public const array PROPERTY_MAP = [
        'cache_created_input_tokens' => ['cache_created_input_tokens', null],
        'cache_creation' => ['cache_creation', \Acme\DigitalOcean\Generated\Model\CompletionUsageCache_creation::class],
        'cache_read_input_tokens' => ['cache_read_input_tokens', null],
        'completion_tokens' => ['completion_tokens', null],
        'prompt_tokens' => ['prompt_tokens', null],
        'total_tokens' => ['total_tokens', null],
    ];

    public function __construct(
        public int $cache_created_input_tokens,
        public CompletionUsageCache_creation $cache_creation,
        public int $cache_read_input_tokens,
        public int $completion_tokens,
        public int $prompt_tokens,
        public int $total_tokens,
    ) {
    }

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'cache_created_input_tokens' => $this->cache_created_input_tokens,
            'cache_creation' => $this->cache_creation,
            'cache_read_input_tokens' => $this->cache_read_input_tokens,
            'completion_tokens' => $this->completion_tokens,
            'prompt_tokens' => $this->prompt_tokens,
            'total_tokens' => $this->total_tokens,
        ];
    }
}
