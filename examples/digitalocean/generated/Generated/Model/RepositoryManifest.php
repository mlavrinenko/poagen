<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

use DateTimeImmutable;
use JsonSerializable;

final readonly class RepositoryManifest implements JsonSerializable
{
    /**
     * Paogen marshal/unmarshal contract — phpName => [wireKey, shape]. See ADR-007.
     * @var array<string, array{0: string, 1: null|class-string|array{0: string, 1: null|class-string}|array{0: string, 1: list<class-string>, 2: ?string}}>
     */
    public const array PROPERTY_MAP = [
        'blobs' => ['blobs', ['list', \Acme\DigitalOcean\Generated\Model\RepositoryBlob::class]],
        'compressed_size_bytes' => ['compressed_size_bytes', null],
        'digest' => ['digest', null],
        'registry_name' => ['registry_name', null],
        'repository' => ['repository', null],
        'size_bytes' => ['size_bytes', null],
        'tags' => ['tags', ['list', null]],
        'updated_at' => ['updated_at', ['datetime', null]],
    ];

    /**
     * @param ?list<\Acme\DigitalOcean\Generated\Model\RepositoryBlob> $blobs
     * @param ?list<string> $tags
     */
    public function __construct(
        public ?array $blobs = null,
        public ?int $compressed_size_bytes = null,
        public ?string $digest = null,
        public ?string $registry_name = null,
        public ?string $repository = null,
        public ?int $size_bytes = null,
        public ?array $tags = null,
        public ?DateTimeImmutable $updated_at = null,
    ) {
    }

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'blobs' => $this->blobs,
            'compressed_size_bytes' => $this->compressed_size_bytes,
            'digest' => $this->digest,
            'registry_name' => $this->registry_name,
            'repository' => $this->repository,
            'size_bytes' => $this->size_bytes,
            'tags' => $this->tags,
            'updated_at' => $this->updated_at?->format(\DateTimeInterface::RFC3339),
        ];
    }
}
