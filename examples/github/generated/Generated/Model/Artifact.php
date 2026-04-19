<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

use DateTimeImmutable;
use JsonSerializable;

final readonly class Artifact implements JsonSerializable
{
    /**
     * Paogen marshal/unmarshal contract — phpName => [wireKey, shape]. See ADR-007.
     * @var array<string, array{0: string, 1: null|class-string|array{0: string, 1: null|class-string}|array{0: string, 1: list<class-string>, 2: ?string}}>
     */
    public const array PROPERTY_MAP = [
        'archive_download_url' => ['archive_download_url', null],
        'created_at' => ['created_at', ['datetime', null]],
        'expired' => ['expired', null],
        'expires_at' => ['expires_at', ['datetime', null]],
        'id' => ['id', null],
        'name' => ['name', null],
        'node_id' => ['node_id', null],
        'size_in_bytes' => ['size_in_bytes', null],
        'updated_at' => ['updated_at', ['datetime', null]],
        'url' => ['url', null],
        'digest' => ['digest', null],
        'workflow_run' => ['workflow_run', \Acme\GitHub\Generated\Model\ArtifactWorkflow_run::class],
    ];

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

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'archive_download_url' => $this->archive_download_url,
            'created_at' => $this->created_at?->format(\DateTimeInterface::RFC3339),
            'expired' => $this->expired,
            'expires_at' => $this->expires_at?->format(\DateTimeInterface::RFC3339),
            'id' => $this->id,
            'name' => $this->name,
            'node_id' => $this->node_id,
            'size_in_bytes' => $this->size_in_bytes,
            'updated_at' => $this->updated_at?->format(\DateTimeInterface::RFC3339),
            'url' => $this->url,
            'digest' => $this->digest,
            'workflow_run' => $this->workflow_run,
        ];
    }
}
