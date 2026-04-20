<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

use DateTimeImmutable;

final readonly class CodeScanningCodeqlDatabase
{
    public function __construct(
        public string $content_type,
        public DateTimeImmutable $created_at,
        public int $id,
        public string $language,
        public string $name,
        public int $size,
        public DateTimeImmutable $updated_at,
        public SimpleUser $uploader,
        public string $url,
        public ?string $commit_oid = null,
    ) {
    }
}
