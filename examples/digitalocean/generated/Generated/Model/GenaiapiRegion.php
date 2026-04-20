<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

final readonly class GenaiapiRegion
{
    public function __construct(
        public ?string $inference_url = null,
        public ?string $region = null,
        public ?bool $serves_batch = null,
        public ?bool $serves_inference = null,
        public ?string $stream_inference_url = null,
    ) {
    }
}
