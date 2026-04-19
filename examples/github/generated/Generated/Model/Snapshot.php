<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

use DateTimeImmutable;
use JsonSerializable;

final readonly class Snapshot implements JsonSerializable
{
    /**
     * Paogen marshal/unmarshal contract — phpName => [wireKey, shape]. See ADR-007.
     * @var array<string, array{0: string, 1: null|class-string|array{0: string, 1: null|class-string}|array{0: string, 1: list<class-string>, 2: ?string}}>
     */
    public const array PROPERTY_MAP = [
        'detector' => ['detector', \Acme\GitHub\Generated\Model\SnapshotDetector::class],
        'job' => ['job', \Acme\GitHub\Generated\Model\SnapshotJob::class],
        'ref' => ['ref', null],
        'scanned' => ['scanned', ['datetime', null]],
        'sha' => ['sha', null],
        'version' => ['version', null],
        'manifests' => ['manifests', null],
        'metadata' => ['metadata', \Acme\GitHub\Generated\Model\Metadata::class],
    ];

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

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'detector' => $this->detector,
            'job' => $this->job,
            'ref' => $this->ref,
            'scanned' => $this->scanned->format(\DateTimeInterface::RFC3339),
            'sha' => $this->sha,
            'version' => $this->version,
            'manifests' => $this->manifests,
            'metadata' => $this->metadata,
        ];
    }
}
