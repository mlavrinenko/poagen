<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

final readonly class RepositoryV2
{
    public function __construct(
        public ?RepositoryManifest $latest_manifest = null,
        public ?int $manifest_count = null,
        public ?string $name = null,
        public ?string $registry_name = null,
        public ?int $tag_count = null,
    ) {
    }
}
