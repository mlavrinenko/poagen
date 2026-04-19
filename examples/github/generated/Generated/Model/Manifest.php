<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

use JsonSerializable;

final readonly class Manifest implements JsonSerializable
{
    /**
     * Paogen marshal/unmarshal contract — phpName => [wireKey, shape]. See ADR-007.
     * @var array<string, array{0: string, 1: null|class-string|array{0: string, 1: null|class-string}|array{0: string, 1: list<class-string>, 2: ?string}}>
     */
    public const array PROPERTY_MAP = [
        'name' => ['name', null],
        'file' => ['file', \Acme\GitHub\Generated\Model\ManifestFile::class],
        'metadata' => ['metadata', \Acme\GitHub\Generated\Model\Metadata::class],
        'resolved' => ['resolved', null],
    ];

    /**
     * @param ?array<string, \Acme\GitHub\Generated\Model\Dependency> $resolved
     */
    public function __construct(
        public string $name,
        public ?ManifestFile $file = null,
        public ?Metadata $metadata = null,
        public ?array $resolved = null,
    ) {
    }

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'name' => $this->name,
            'file' => $this->file,
            'metadata' => $this->metadata,
            'resolved' => $this->resolved,
        ];
    }
}
