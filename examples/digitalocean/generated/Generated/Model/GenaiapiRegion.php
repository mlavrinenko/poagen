<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

use JsonSerializable;

final readonly class GenaiapiRegion implements JsonSerializable
{
    /**
     * Paogen marshal/unmarshal contract — phpName => [wireKey, shape]. See ADR-007.
     * @var array<string, array{0: string, 1: null|class-string|array{0: string, 1: null|class-string}|array{0: string, 1: list<class-string>, 2: ?string}}>
     */
    public const array PROPERTY_MAP = [
        'inference_url' => ['inference_url', null],
        'region' => ['region', null],
        'serves_batch' => ['serves_batch', null],
        'serves_inference' => ['serves_inference', null],
        'stream_inference_url' => ['stream_inference_url', null],
    ];

    public function __construct(
        public ?string $inference_url = null,
        public ?string $region = null,
        public ?bool $serves_batch = null,
        public ?bool $serves_inference = null,
        public ?string $stream_inference_url = null,
    ) {
    }

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'inference_url' => $this->inference_url,
            'region' => $this->region,
            'serves_batch' => $this->serves_batch,
            'serves_inference' => $this->serves_inference,
            'stream_inference_url' => $this->stream_inference_url,
        ];
    }
}
