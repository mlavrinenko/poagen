<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

use JsonSerializable;

final readonly class CreateImageRequest implements JsonSerializable
{
    /**
     * Paogen marshal/unmarshal contract — phpName => [wireKey, shape]. See ADR-007.
     * @var array<string, array{0: string, 1: null|class-string|array{0: string, 1: null|class-string}|array{0: string, 1: list<class-string>, 2: ?string}}>
     */
    public const array PROPERTY_MAP = [
        'model' => ['model', null],
        'n' => ['n', null],
        'prompt' => ['prompt', null],
        'background' => ['background', null],
        'moderation' => ['moderation', null],
        'output_compression' => ['output_compression', null],
        'output_format' => ['output_format', null],
        'partial_images' => ['partial_images', null],
        'quality' => ['quality', null],
        'size' => ['size', null],
        'stream' => ['stream', null],
        'user' => ['user', null],
    ];

    public function __construct(
        public string $model,
        public int $n,
        public string $prompt,
        public ?string $background = null,
        public ?string $moderation = null,
        public ?int $output_compression = null,
        public ?string $output_format = null,
        public ?int $partial_images = null,
        public ?string $quality = null,
        public ?string $size = null,
        public ?bool $stream = null,
        public ?string $user = null,
    ) {
    }

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'model' => $this->model,
            'n' => $this->n,
            'prompt' => $this->prompt,
            'background' => $this->background,
            'moderation' => $this->moderation,
            'output_compression' => $this->output_compression,
            'output_format' => $this->output_format,
            'partial_images' => $this->partial_images,
            'quality' => $this->quality,
            'size' => $this->size,
            'stream' => $this->stream,
            'user' => $this->user,
        ];
    }
}
