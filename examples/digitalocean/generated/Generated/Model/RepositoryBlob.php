<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

use JsonSerializable;

final readonly class RepositoryBlob implements JsonSerializable
{
    /**
     * Paogen marshal/unmarshal contract — phpName => [wireKey, shape]. See ADR-007.
     * @var array<string, array{0: string, 1: null|class-string|array{0: string, 1: null|class-string}|array{0: string, 1: list<class-string>, 2: ?string}}>
     */
    public const array PROPERTY_MAP = [
        'compressed_size_bytes' => ['compressed_size_bytes', null],
        'digest' => ['digest', null],
    ];

    public function __construct(
        public ?int $compressed_size_bytes = null,
        public ?string $digest = null,
    ) {
    }

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'compressed_size_bytes' => $this->compressed_size_bytes,
            'digest' => $this->digest,
        ];
    }
}
