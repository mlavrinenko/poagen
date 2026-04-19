<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

use Acme\DigitalOcean\Generated\Enum\RegionSlug;
use JsonSerializable;

final readonly class VolumeActionPostAttach implements JsonSerializable
{
    /**
     * Paogen marshal/unmarshal contract — phpName => [wireKey, shape]. See ADR-007.
     * @var array<string, array{0: string, 1: null|class-string|array{0: string, 1: null|class-string}|array{0: string, 1: list<class-string>, 2: ?string}}>
     */
    public const array PROPERTY_MAP = [
        'droplet_id' => ['droplet_id', \Acme\DigitalOcean\Generated\Model\VolumeActionDropletId::class],
        'type' => ['type', null],
        'region' => ['region', ['enum', \Acme\DigitalOcean\Generated\Enum\RegionSlug::class]],
        'tags' => ['tags', \Acme\DigitalOcean\Generated\Model\TagsArray::class],
    ];

    public function __construct(
        public VolumeActionDropletId $droplet_id,
        public string $type,
        public ?RegionSlug $region = null,
        public ?TagsArray $tags = null,
    ) {
    }

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'droplet_id' => $this->droplet_id,
            'type' => $this->type,
            'region' => $this->region,
            'tags' => $this->tags,
        ];
    }
}
