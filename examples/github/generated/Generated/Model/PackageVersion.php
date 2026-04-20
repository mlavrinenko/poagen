<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

use DateTimeImmutable;

final readonly class PackageVersion
{
    public function __construct(
        public DateTimeImmutable $created_at,
        public int $id,
        public string $name,
        public string $package_html_url,
        public DateTimeImmutable $updated_at,
        public string $url,
        public ?DateTimeImmutable $deleted_at = null,
        public ?string $description = null,
        public ?string $html_url = null,
        public ?string $license = null,
        public ?PackageVersionMetadata $metadata = null,
    ) {
    }
}
