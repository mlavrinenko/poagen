<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

use Acme\DigitalOcean\Generated\Enum\Distribution;
use DateTimeImmutable;
use JsonSerializable;

final readonly class Image implements JsonSerializable
{
    /**
     * Paogen marshal/unmarshal contract — phpName => [wireKey, shape]. See ADR-007.
     * @var array<string, array{0: string, 1: null|class-string|array{0: string, 1: null|class-string}|array{0: string, 1: list<class-string>, 2: ?string}}>
     */
    public const array PROPERTY_MAP = [
        'created_at' => ['created_at', ['datetime', null]],
        'description' => ['description', \Acme\DigitalOcean\Generated\Model\ImageDescription::class],
        'distribution' => ['distribution', ['enum', \Acme\DigitalOcean\Generated\Enum\Distribution::class]],
        'error_message' => ['error_message', null],
        'id' => ['id', null],
        'min_disk_size' => ['min_disk_size', null],
        'name' => ['name', \Acme\DigitalOcean\Generated\Model\ImageName::class],
        'public' => ['public', null],
        'regions' => ['regions', \Acme\DigitalOcean\Generated\Model\RegionsArray::class],
        'size_gigabytes' => ['size_gigabytes', null],
        'slug' => ['slug', null],
        'status' => ['status', null],
        'tags' => ['tags', \Acme\DigitalOcean\Generated\Model\TagsArray::class],
        'type' => ['type', null],
    ];

    public function __construct(
        public ?DateTimeImmutable $created_at = null,
        public ?ImageDescription $description = null,
        public ?Distribution $distribution = null,
        public ?string $error_message = null,
        public ?int $id = null,
        public ?int $min_disk_size = null,
        public ?ImageName $name = null,
        public ?bool $public = null,
        public ?RegionsArray $regions = null,
        public ?float $size_gigabytes = null,
        public ?string $slug = null,
        public ?string $status = null,
        public ?TagsArray $tags = null,
        public ?string $type = null,
    ) {
    }

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'created_at' => $this->created_at?->format(\DateTimeInterface::RFC3339),
            'description' => $this->description,
            'distribution' => $this->distribution,
            'error_message' => $this->error_message,
            'id' => $this->id,
            'min_disk_size' => $this->min_disk_size,
            'name' => $this->name,
            'public' => $this->public,
            'regions' => $this->regions,
            'size_gigabytes' => $this->size_gigabytes,
            'slug' => $this->slug,
            'status' => $this->status,
            'tags' => $this->tags,
            'type' => $this->type,
        ];
    }
}
