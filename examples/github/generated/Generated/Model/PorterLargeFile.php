<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

use JsonSerializable;

final readonly class PorterLargeFile implements JsonSerializable
{
    /**
     * Paogen marshal/unmarshal contract — phpName => [wireKey, shape]. See ADR-007.
     * @var array<string, array{0: string, 1: null|class-string|array{0: string, 1: null|class-string}|array{0: string, 1: list<class-string>, 2: ?string}}>
     */
    public const array PROPERTY_MAP = [
        'oid' => ['oid', null],
        'path' => ['path', null],
        'ref_name' => ['ref_name', null],
        'size' => ['size', null],
    ];

    public function __construct(
        public string $oid,
        public string $path,
        public string $ref_name,
        public int $size,
    ) {
    }

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'oid' => $this->oid,
            'path' => $this->path,
            'ref_name' => $this->ref_name,
            'size' => $this->size,
        ];
    }
}
