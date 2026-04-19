<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

use JsonSerializable;

final readonly class ApiFileUploadDataSource implements JsonSerializable
{
    /**
     * Paogen marshal/unmarshal contract — phpName => [wireKey, shape]. See ADR-007.
     * @var array<string, array{0: string, 1: null|class-string|array{0: string, 1: null|class-string}|array{0: string, 1: list<class-string>, 2: ?string}}>
     */
    public const array PROPERTY_MAP = [
        'original_file_name' => ['original_file_name', null],
        'size_in_bytes' => ['size_in_bytes', null],
        'stored_object_key' => ['stored_object_key', null],
    ];

    public function __construct(
        public ?string $original_file_name = null,
        public ?string $size_in_bytes = null,
        public ?string $stored_object_key = null,
    ) {
    }

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'original_file_name' => $this->original_file_name,
            'size_in_bytes' => $this->size_in_bytes,
            'stored_object_key' => $this->stored_object_key,
        ];
    }
}
