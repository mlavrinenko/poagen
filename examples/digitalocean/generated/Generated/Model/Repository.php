<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

final readonly class Repository
{
    public function __construct(
        public ?RepositoryTag $latest_tag = null,
        public ?string $name = null,
        public ?string $registry_name = null,
        public ?int $tag_count = null,
    ) {
    }
}
