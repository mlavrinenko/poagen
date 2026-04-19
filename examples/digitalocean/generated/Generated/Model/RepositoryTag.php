<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

use DateTimeImmutable;
use JsonSerializable;

final readonly class RepositoryTag implements JsonSerializable
{
    /**
     * Paogen marshal/unmarshal contract — phpName => [wireKey, shape]. See ADR-007.
     * @var array<string, array{0: string, 1: null|class-string|array{0: string, 1: null|class-string}|array{0: string, 1: list<class-string>, 2: ?string}}>
     */
    public const array PROPERTY_MAP = [
        'compressed_size_bytes' => ['compressed_size_bytes', null],
        'manifest_digest' => ['manifest_digest', null],
        'registry_name' => ['registry_name', null],
        'repository' => ['repository', null],
        'size_bytes' => ['size_bytes', null],
        'tag' => ['tag', null],
        'updated_at' => ['updated_at', ['datetime', null]],
    ];

    public function __construct(
        public ?int $compressed_size_bytes = null,
        public ?string $manifest_digest = null,
        public ?string $registry_name = null,
        public ?string $repository = null,
        public ?int $size_bytes = null,
        public ?string $tag = null,
        public ?DateTimeImmutable $updated_at = null,
    ) {
    }

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'compressed_size_bytes' => $this->compressed_size_bytes,
            'manifest_digest' => $this->manifest_digest,
            'registry_name' => $this->registry_name,
            'repository' => $this->repository,
            'size_bytes' => $this->size_bytes,
            'tag' => $this->tag,
            'updated_at' => $this->updated_at?->format(\DateTimeInterface::RFC3339),
        ];
    }
}
