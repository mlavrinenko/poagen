<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

final readonly class ApiCreateDataSourceFileUploadPresignedUrlsInputPublic
{
    /**
     * @param ?list<\Acme\DigitalOcean\Generated\Model\ApiPresignedUrlFile> $files
     */
    public function __construct(
        public ?array $files = null,
    ) {
    }
}
