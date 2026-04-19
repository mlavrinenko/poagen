<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

use JsonSerializable;

final readonly class AcceleratorConfigSpec implements JsonSerializable
{
    /**
     * Paogen marshal/unmarshal contract — phpName => [wireKey, shape]. See ADR-007.
     * @var array<string, array{0: string, 1: null|class-string|array{0: string, 1: null|class-string}|array{0: string, 1: list<class-string>, 2: ?string}}>
     */
    public const array PROPERTY_MAP = [
        'accelerator_slug' => ['accelerator_slug', null],
        'scale' => ['scale', null],
        'type' => ['type', null],
        'status' => ['status', null],
    ];

    public function __construct(
        public string $accelerator_slug,
        public int $scale,
        public string $type,
        public ?string $status = null,
    ) {
    }

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'accelerator_slug' => $this->accelerator_slug,
            'scale' => $this->scale,
            'type' => $this->type,
            'status' => $this->status,
        ];
    }
}
