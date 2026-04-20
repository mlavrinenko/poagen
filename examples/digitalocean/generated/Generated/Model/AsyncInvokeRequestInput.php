<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

final readonly class AsyncInvokeRequestInput
{
    public function __construct(
        public ?bool $enable_safety_checker = null,
        public ?float $guidance_scale = null,
        public ?int $num_images = null,
        public ?int $num_inference_steps = null,
        public ?string $output_format = null,
        public ?string $prompt = null,
        public ?int $seconds_total = null,
        public ?string $text = null,
    ) {
    }
}
