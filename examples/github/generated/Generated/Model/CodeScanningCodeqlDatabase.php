<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

use DateTimeImmutable;
use JsonSerializable;

final readonly class CodeScanningCodeqlDatabase implements JsonSerializable
{
    /**
     * Paogen marshal/unmarshal contract — phpName => [wireKey, shape]. See ADR-007.
     * @var array<string, array{0: string, 1: null|class-string|array{0: string, 1: null|class-string}|array{0: string, 1: list<class-string>, 2: ?string}}>
     */
    public const array PROPERTY_MAP = [
        'content_type' => ['content_type', null],
        'created_at' => ['created_at', ['datetime', null]],
        'id' => ['id', null],
        'language' => ['language', null],
        'name' => ['name', null],
        'size' => ['size', null],
        'updated_at' => ['updated_at', ['datetime', null]],
        'uploader' => ['uploader', \Acme\GitHub\Generated\Model\SimpleUser::class],
        'url' => ['url', null],
        'commit_oid' => ['commit_oid', null],
    ];

    public function __construct(
        public string $content_type,
        public DateTimeImmutable $created_at,
        public int $id,
        public string $language,
        public string $name,
        public int $size,
        public DateTimeImmutable $updated_at,
        public SimpleUser $uploader,
        public string $url,
        public ?string $commit_oid = null,
    ) {
    }

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'content_type' => $this->content_type,
            'created_at' => $this->created_at->format(\DateTimeInterface::RFC3339),
            'id' => $this->id,
            'language' => $this->language,
            'name' => $this->name,
            'size' => $this->size,
            'updated_at' => $this->updated_at->format(\DateTimeInterface::RFC3339),
            'uploader' => $this->uploader,
            'url' => $this->url,
            'commit_oid' => $this->commit_oid,
        ];
    }
}
