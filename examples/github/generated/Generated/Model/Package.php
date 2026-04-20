<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

use DateTimeImmutable;

final readonly class Package
{
    public function __construct(
        public DateTimeImmutable $created_at,
        public string $html_url,
        public int $id,
        public string $name,
        public string $package_type,
        public DateTimeImmutable $updated_at,
        public string $url,
        public int $version_count,
        public string $visibility,
        public ?NullableSimpleUser $owner = null,
        public ?NullableMinimalRepository $repository = null,
    ) {
    }
}
