<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

final readonly class WebhookRubygemsMetadata
{
    /**
     * @param ?list<array<string, string>> $dependencies
     * @param ?array<string, string> $metadata
     */
    public function __construct(
        public ?string $commit_oid = null,
        public ?array $dependencies = null,
        public ?string $description = null,
        public ?string $homepage = null,
        public ?array $metadata = null,
        public ?string $name = null,
        public ?string $platform = null,
        public ?string $readme = null,
        public ?string $repo = null,
        public ?WebhookRubygemsMetadataVersion_info $version_info = null,
    ) {
    }
}
