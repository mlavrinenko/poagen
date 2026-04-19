<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

use JsonSerializable;

final readonly class ResponseUsageOutput_tokens_details implements JsonSerializable
{
    /**
     * Paogen marshal/unmarshal contract — phpName => [wireKey, shape]. See ADR-007.
     * @var array<string, array{0: string, 1: null|class-string|array{0: string, 1: null|class-string}|array{0: string, 1: list<class-string>, 2: ?string}}>
     */
    public const array PROPERTY_MAP = [
        'reasoning_tokens' => ['reasoning_tokens', null],
        'tool_output_tokens' => ['tool_output_tokens', null],
    ];

    public function __construct(
        public int $reasoning_tokens,
        public int $tool_output_tokens,
    ) {
    }

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'reasoning_tokens' => $this->reasoning_tokens,
            'tool_output_tokens' => $this->tool_output_tokens,
        ];
    }
}
