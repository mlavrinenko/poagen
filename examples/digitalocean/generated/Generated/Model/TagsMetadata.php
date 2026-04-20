<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

final readonly class TagsMetadata
{
    public function __construct(
        public ?int $count = null,
        public ?string $last_tagged_uri = null,
    ) {
    }
}
