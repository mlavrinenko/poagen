<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

use Acme\DigitalOcean\Generated\Enum\RegionSlug;
use JsonSerializable;

final readonly class VolumeActionPostResize implements JsonSerializable
{
    /**
     * Paogen marshal/unmarshal contract — phpName => [wireKey, shape]. See ADR-007.
     * @var array<string, array{0: string, 1: null|class-string|array{0: string, 1: null|class-string}|array{0: string, 1: list<class-string>, 2: ?string}}>
     */
    public const array PROPERTY_MAP = [
        'size_gigabytes' => ['size_gigabytes', null],
        'type' => ['type', null],
        'region' => ['region', ['enum', \Acme\DigitalOcean\Generated\Enum\RegionSlug::class]],
    ];

    public function __construct(
        public int $size_gigabytes,
        public string $type,
        public ?RegionSlug $region = null,
    ) {
    }

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'size_gigabytes' => $this->size_gigabytes,
            'type' => $this->type,
            'region' => $this->region,
        ];
    }
}
