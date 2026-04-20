<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

final readonly class PackageVersionMetadataDocker
{
    /**
     * @param ?list<string> $tag
     */
    public function __construct(
        public ?array $tag = null,
    ) {
    }
}
