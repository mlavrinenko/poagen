<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

use JsonSerializable;

final readonly class ApiCreateDataSourceFileUploadPresignedUrlsOutput implements JsonSerializable
{
    /**
     * Paogen marshal/unmarshal contract — phpName => [wireKey, shape]. See ADR-007.
     * @var array<string, array{0: string, 1: null|class-string|array{0: string, 1: null|class-string}|array{0: string, 1: list<class-string>, 2: ?string}}>
     */
    public const array PROPERTY_MAP = [
        'request_id' => ['request_id', null],
        'uploads' => ['uploads', ['list', \Acme\DigitalOcean\Generated\Model\ApiFilePresignedUrlResponse::class]],
    ];

    /**
     * @param ?list<\Acme\DigitalOcean\Generated\Model\ApiFilePresignedUrlResponse> $uploads
     */
    public function __construct(
        public ?string $request_id = null,
        public ?array $uploads = null,
    ) {
    }

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'request_id' => $this->request_id,
            'uploads' => $this->uploads,
        ];
    }
}
