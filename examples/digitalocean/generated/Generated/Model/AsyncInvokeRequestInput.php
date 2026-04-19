<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

use JsonSerializable;

final readonly class AsyncInvokeRequestInput implements JsonSerializable
{
    /**
     * Paogen marshal/unmarshal contract — phpName => [wireKey, shape]. See ADR-007.
     * @var array<string, array{0: string, 1: null|class-string|array{0: string, 1: null|class-string}|array{0: string, 1: list<class-string>, 2: ?string}}>
     */
    public const array PROPERTY_MAP = [
        'enable_safety_checker' => ['enable_safety_checker', null],
        'guidance_scale' => ['guidance_scale', null],
        'num_images' => ['num_images', null],
        'num_inference_steps' => ['num_inference_steps', null],
        'output_format' => ['output_format', null],
        'prompt' => ['prompt', null],
        'seconds_total' => ['seconds_total', null],
        'text' => ['text', null],
    ];

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

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'enable_safety_checker' => $this->enable_safety_checker,
            'guidance_scale' => $this->guidance_scale,
            'num_images' => $this->num_images,
            'num_inference_steps' => $this->num_inference_steps,
            'output_format' => $this->output_format,
            'prompt' => $this->prompt,
            'seconds_total' => $this->seconds_total,
            'text' => $this->text,
        ];
    }
}
