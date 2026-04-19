<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

use Acme\DigitalOcean\Generated\Enum\RegionSlug;
use JsonSerializable;

final readonly class ImageActionTransfer implements JsonSerializable
{
    /**
     * Paogen marshal/unmarshal contract — phpName => [wireKey, shape]. See ADR-007.
     * @var array<string, array{0: string, 1: null|class-string|array{0: string, 1: null|class-string}|array{0: string, 1: list<class-string>, 2: ?string}}>
     */
    public const array PROPERTY_MAP = [
        'region' => ['region', ['enum', \Acme\DigitalOcean\Generated\Enum\RegionSlug::class]],
        'type' => ['type', null],
    ];

    public function __construct(
        public RegionSlug $region,
        public string $type,
    ) {
    }

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'region' => $this->region,
            'type' => $this->type,
        ];
    }
}
