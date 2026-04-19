<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

use JsonSerializable;

final readonly class ImagesResponse implements JsonSerializable
{
    /**
     * Paogen marshal/unmarshal contract — phpName => [wireKey, shape]. See ADR-007.
     * @var array<string, array{0: string, 1: null|class-string|array{0: string, 1: null|class-string}|array{0: string, 1: list<class-string>, 2: ?string}}>
     */
    public const array PROPERTY_MAP = [
        'created' => ['created', null],
        'data' => ['data', ['list', \Acme\DigitalOcean\Generated\Model\GeneratedImage::class]],
        'background' => ['background', null],
        'output_format' => ['output_format', null],
        'quality' => ['quality', null],
        'size' => ['size', null],
        'usage' => ['usage', null],
    ];

    /**
     * @param list<\Acme\DigitalOcean\Generated\Model\GeneratedImage> $data
     * @param ?mixed $usage
     */
    public function __construct(
        public int $created,
        public array $data,
        public ?string $background = null,
        public ?string $output_format = null,
        public ?string $quality = null,
        public ?string $size = null,
        public $usage = null,
    ) {
    }

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'created' => $this->created,
            'data' => $this->data,
            'background' => $this->background,
            'output_format' => $this->output_format,
            'quality' => $this->quality,
            'size' => $this->size,
            'usage' => $this->usage,
        ];
    }
}
