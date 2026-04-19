<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

use DateTimeImmutable;
use JsonSerializable;

final readonly class PackageVersion implements JsonSerializable
{
    /**
     * Paogen marshal/unmarshal contract — phpName => [wireKey, shape]. See ADR-007.
     * @var array<string, array{0: string, 1: null|class-string|array{0: string, 1: null|class-string}|array{0: string, 1: list<class-string>, 2: ?string}}>
     */
    public const array PROPERTY_MAP = [
        'created_at' => ['created_at', ['datetime', null]],
        'id' => ['id', null],
        'name' => ['name', null],
        'package_html_url' => ['package_html_url', null],
        'updated_at' => ['updated_at', ['datetime', null]],
        'url' => ['url', null],
        'deleted_at' => ['deleted_at', ['datetime', null]],
        'description' => ['description', null],
        'html_url' => ['html_url', null],
        'license' => ['license', null],
        'metadata' => ['metadata', \Acme\GitHub\Generated\Model\PackageVersionMetadata::class],
    ];

    public function __construct(
        public DateTimeImmutable $created_at,
        public int $id,
        public string $name,
        public string $package_html_url,
        public DateTimeImmutable $updated_at,
        public string $url,
        public ?DateTimeImmutable $deleted_at = null,
        public ?string $description = null,
        public ?string $html_url = null,
        public ?string $license = null,
        public ?PackageVersionMetadata $metadata = null,
    ) {
    }

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'created_at' => $this->created_at->format(\DateTimeInterface::RFC3339),
            'id' => $this->id,
            'name' => $this->name,
            'package_html_url' => $this->package_html_url,
            'updated_at' => $this->updated_at->format(\DateTimeInterface::RFC3339),
            'url' => $this->url,
            'deleted_at' => $this->deleted_at?->format(\DateTimeInterface::RFC3339),
            'description' => $this->description,
            'html_url' => $this->html_url,
            'license' => $this->license,
            'metadata' => $this->metadata,
        ];
    }
}
