<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

use JsonSerializable;

final readonly class CompletionUsageCache_creation implements JsonSerializable
{
    /**
     * Paogen marshal/unmarshal contract — phpName => [wireKey, shape]. See ADR-007.
     * @var array<string, array{0: string, 1: null|class-string|array{0: string, 1: null|class-string}|array{0: string, 1: list<class-string>, 2: ?string}}>
     */
    public const array PROPERTY_MAP = [
        'ephemeral_1h_input_tokens' => ['ephemeral_1h_input_tokens', null],
        'ephemeral_5m_input_tokens' => ['ephemeral_5m_input_tokens', null],
    ];

    public function __construct(
        public int $ephemeral_1h_input_tokens,
        public int $ephemeral_5m_input_tokens,
    ) {
    }

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'ephemeral_1h_input_tokens' => $this->ephemeral_1h_input_tokens,
            'ephemeral_5m_input_tokens' => $this->ephemeral_5m_input_tokens,
        ];
    }
}
