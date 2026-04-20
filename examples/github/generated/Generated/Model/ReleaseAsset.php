<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

use DateTimeImmutable;

final readonly class ReleaseAsset
{
    public function __construct(
        public string $browser_download_url,
        public string $content_type,
        public DateTimeImmutable $created_at,
        public ?string $digest = null,
        public int $download_count,
        public int $id,
        public ?string $label = null,
        public string $name,
        public string $node_id,
        public int $size,
        public string $state,
        public DateTimeImmutable $updated_at,
        public NullableSimpleUser $uploader,
        public string $url,
    ) {
    }
}
