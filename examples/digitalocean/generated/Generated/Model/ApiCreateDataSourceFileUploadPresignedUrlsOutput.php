<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

final readonly class ApiCreateDataSourceFileUploadPresignedUrlsOutput
{
    /**
     * @param ?list<\Acme\DigitalOcean\Generated\Model\ApiFilePresignedUrlResponse> $uploads
     */
    public function __construct(
        public ?string $request_id = null,
        public ?array $uploads = null,
    ) {
    }
}
