<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

use DateTimeImmutable;
use JsonSerializable;

final readonly class ApiModelPublic implements JsonSerializable
{
    /**
     * Paogen marshal/unmarshal contract — phpName => [wireKey, shape]. See ADR-007.
     * @var array<string, array{0: string, 1: null|class-string|array{0: string, 1: null|class-string}|array{0: string, 1: list<class-string>, 2: ?string}}>
     */
    public const array PROPERTY_MAP = [
        'agreement' => ['agreement', \Acme\DigitalOcean\Generated\Model\ApiAgreement::class],
        'created_at' => ['created_at', ['datetime', null]],
        'id' => ['id', null],
        'is_foundational' => ['is_foundational', null],
        'kb_default_chunk_size' => ['kb_default_chunk_size', null],
        'kb_max_chunk_size' => ['kb_max_chunk_size', null],
        'kb_min_chunk_size' => ['kb_min_chunk_size', null],
        'name' => ['name', null],
        'parent_uuid' => ['parent_uuid', null],
        'updated_at' => ['updated_at', ['datetime', null]],
        'upload_complete' => ['upload_complete', null],
        'url' => ['url', null],
        'uuid' => ['uuid', null],
        'version' => ['version', \Acme\DigitalOcean\Generated\Model\ApiModelVersion::class],
    ];

    public function __construct(
        public ?ApiAgreement $agreement = null,
        public ?DateTimeImmutable $created_at = null,
        public ?string $id = null,
        public ?bool $is_foundational = null,
        public ?int $kb_default_chunk_size = null,
        public ?int $kb_max_chunk_size = null,
        public ?int $kb_min_chunk_size = null,
        public ?string $name = null,
        public ?string $parent_uuid = null,
        public ?DateTimeImmutable $updated_at = null,
        public ?bool $upload_complete = null,
        public ?string $url = null,
        public ?string $uuid = null,
        public ?ApiModelVersion $version = null,
    ) {
    }

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'agreement' => $this->agreement,
            'created_at' => $this->created_at?->format(\DateTimeInterface::RFC3339),
            'id' => $this->id,
            'is_foundational' => $this->is_foundational,
            'kb_default_chunk_size' => $this->kb_default_chunk_size,
            'kb_max_chunk_size' => $this->kb_max_chunk_size,
            'kb_min_chunk_size' => $this->kb_min_chunk_size,
            'name' => $this->name,
            'parent_uuid' => $this->parent_uuid,
            'updated_at' => $this->updated_at?->format(\DateTimeInterface::RFC3339),
            'upload_complete' => $this->upload_complete,
            'url' => $this->url,
            'uuid' => $this->uuid,
            'version' => $this->version,
        ];
    }
}
