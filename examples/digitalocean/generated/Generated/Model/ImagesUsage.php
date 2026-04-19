<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

use JsonSerializable;

final readonly class ImagesUsage implements JsonSerializable
{
    /**
     * Paogen marshal/unmarshal contract — phpName => [wireKey, shape]. See ADR-007.
     * @var array<string, array{0: string, 1: null|class-string|array{0: string, 1: null|class-string}|array{0: string, 1: list<class-string>, 2: ?string}}>
     */
    public const array PROPERTY_MAP = [
        'input_tokens' => ['input_tokens', null],
        'input_tokens_details' => [
            'input_tokens_details',
            \Acme\DigitalOcean\Generated\Model\ImagesUsageInput_tokens_details::class,
        ],
        'output_tokens' => ['output_tokens', null],
        'total_tokens' => ['total_tokens', null],
    ];

    public function __construct(
        public int $input_tokens,
        public ImagesUsageInput_tokens_details $input_tokens_details,
        public int $output_tokens,
        public int $total_tokens,
    ) {
    }

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'input_tokens' => $this->input_tokens,
            'input_tokens_details' => $this->input_tokens_details,
            'output_tokens' => $this->output_tokens,
            'total_tokens' => $this->total_tokens,
        ];
    }
}
