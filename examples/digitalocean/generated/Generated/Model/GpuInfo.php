<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

use JsonSerializable;

final readonly class GpuInfo implements JsonSerializable
{
    /**
     * Paogen marshal/unmarshal contract — phpName => [wireKey, shape]. See ADR-007.
     * @var array<string, array{0: string, 1: null|class-string|array{0: string, 1: null|class-string}|array{0: string, 1: list<class-string>, 2: ?string}}>
     */
    public const array PROPERTY_MAP = [
        'count' => ['count', null],
        'model' => ['model', null],
        'vram' => ['vram', \Acme\DigitalOcean\Generated\Model\GpuInfoVram::class],
    ];

    public function __construct(
        public ?int $count = null,
        public ?string $model = null,
        public ?GpuInfoVram $vram = null,
    ) {
    }

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'count' => $this->count,
            'model' => $this->model,
            'vram' => $this->vram,
        ];
    }
}
