<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

use DateTimeImmutable;

final readonly class Snapshot
{
    /**
     * @param ?array<string, \Acme\GitHub\Generated\Model\Manifest> $manifests
     */
    public function __construct(
        public SnapshotDetector $detector,
        public SnapshotJob $job,
        public string $ref,
        public DateTimeImmutable $scanned,
        public string $sha,
        public int $version,
        public ?array $manifests = null,
        public ?Metadata $metadata = null,
    ) {
    }
}
