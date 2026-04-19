<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

use JsonSerializable;

final readonly class VolumeFull implements JsonSerializable
{
    /**
     * Paogen marshal/unmarshal contract — phpName => [wireKey, shape]. See ADR-007.
     * @var array<string, array{0: string, 1: null|class-string|array{0: string, 1: null|class-string}|array{0: string, 1: list<class-string>, 2: ?string}}>
     */
    public const array PROPERTY_MAP = [
        'created_at' => ['created_at', null],
        'description' => ['description', null],
        'droplet_ids' => ['droplet_ids', ['list', null]],
        'filesystem_label' => ['filesystem_label', null],
        'filesystem_type' => ['filesystem_type', null],
        'id' => ['id', null],
        'name' => ['name', null],
        'region' => ['region', null],
        'size_gigabytes' => ['size_gigabytes', null],
        'tags' => ['tags', \Acme\DigitalOcean\Generated\Model\TagsArrayRead::class],
    ];

    /**
     * @param ?list<int> $droplet_ids
     * @param ?mixed $region
     */
    public function __construct(
        public ?string $created_at = null,
        public ?string $description = null,
        public ?array $droplet_ids = null,
        public ?string $filesystem_label = null,
        public ?string $filesystem_type = null,
        public ?string $id = null,
        public ?string $name = null,
        public $region = null,
        public ?int $size_gigabytes = null,
        public ?TagsArrayRead $tags = null,
    ) {
    }

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'created_at' => $this->created_at,
            'description' => $this->description,
            'droplet_ids' => $this->droplet_ids,
            'filesystem_label' => $this->filesystem_label,
            'filesystem_type' => $this->filesystem_type,
            'id' => $this->id,
            'name' => $this->name,
            'region' => $this->region,
            'size_gigabytes' => $this->size_gigabytes,
            'tags' => $this->tags,
        ];
    }
}
