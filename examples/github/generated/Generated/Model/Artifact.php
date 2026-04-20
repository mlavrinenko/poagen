<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

use DateTimeImmutable;

final readonly class Artifact
{
    public function __construct(
        public string $archive_download_url,
        public ?DateTimeImmutable $created_at = null,
        public bool $expired,
        public ?DateTimeImmutable $expires_at = null,
        public int $id,
        public string $name,
        public string $node_id,
        public int $size_in_bytes,
        public ?DateTimeImmutable $updated_at = null,
        public string $url,
        public ?string $digest = null,
        public ?ArtifactWorkflow_run $workflow_run = null,
    ) {
    }
}
