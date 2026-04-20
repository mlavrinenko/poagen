<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

final readonly class Manifest
{
    /**
     * @param ?array<string, \Acme\GitHub\Generated\Model\Dependency> $resolved
     */
    public function __construct(
        public string $name,
        public ?ManifestFile $file = null,
        public ?Metadata $metadata = null,
        public ?array $resolved = null,
    ) {
    }
}
