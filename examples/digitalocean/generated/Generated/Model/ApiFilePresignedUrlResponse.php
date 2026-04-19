<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

use DateTimeImmutable;
use JsonSerializable;

final readonly class ApiFilePresignedUrlResponse implements JsonSerializable
{
    /**
     * Paogen marshal/unmarshal contract — phpName => [wireKey, shape]. See ADR-007.
     * @var array<string, array{0: string, 1: null|class-string|array{0: string, 1: null|class-string}|array{0: string, 1: list<class-string>, 2: ?string}}>
     */
    public const array PROPERTY_MAP = [
        'expires_at' => ['expires_at', ['datetime', null]],
        'object_key' => ['object_key', null],
        'original_file_name' => ['original_file_name', null],
        'presigned_url' => ['presigned_url', null],
    ];

    public function __construct(
        public ?DateTimeImmutable $expires_at = null,
        public ?string $object_key = null,
        public ?string $original_file_name = null,
        public ?string $presigned_url = null,
    ) {
    }

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'expires_at' => $this->expires_at?->format(\DateTimeInterface::RFC3339),
            'object_key' => $this->object_key,
            'original_file_name' => $this->original_file_name,
            'presigned_url' => $this->presigned_url,
        ];
    }
}
