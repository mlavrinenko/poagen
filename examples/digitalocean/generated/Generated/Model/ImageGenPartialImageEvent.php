<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

use JsonSerializable;

final readonly class ImageGenPartialImageEvent implements JsonSerializable
{
    /**
     * Paogen marshal/unmarshal contract — phpName => [wireKey, shape]. See ADR-007.
     * @var array<string, array{0: string, 1: null|class-string|array{0: string, 1: null|class-string}|array{0: string, 1: list<class-string>, 2: ?string}}>
     */
    public const array PROPERTY_MAP = [
        'b64_json' => ['b64_json', null],
        'background' => ['background', null],
        'created_at' => ['created_at', null],
        'output_format' => ['output_format', null],
        'partial_image_index' => ['partial_image_index', null],
        'quality' => ['quality', null],
        'size' => ['size', null],
        'type' => ['type', null],
    ];

    public function __construct(
        public string $b64_json,
        public string $background,
        public int $created_at,
        public string $output_format,
        public int $partial_image_index,
        public string $quality,
        public string $size,
        public string $type,
    ) {
    }

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'b64_json' => $this->b64_json,
            'background' => $this->background,
            'created_at' => $this->created_at,
            'output_format' => $this->output_format,
            'partial_image_index' => $this->partial_image_index,
            'quality' => $this->quality,
            'size' => $this->size,
            'type' => $this->type,
        ];
    }
}
