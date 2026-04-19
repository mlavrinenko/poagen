<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

use JsonSerializable;

final readonly class DiffEntry implements JsonSerializable
{
    /**
     * Paogen marshal/unmarshal contract — phpName => [wireKey, shape]. See ADR-007.
     * @var array<string, array{0: string, 1: null|class-string|array{0: string, 1: null|class-string}|array{0: string, 1: list<class-string>, 2: ?string}}>
     */
    public const array PROPERTY_MAP = [
        'additions' => ['additions', null],
        'blob_url' => ['blob_url', null],
        'changes' => ['changes', null],
        'contents_url' => ['contents_url', null],
        'deletions' => ['deletions', null],
        'filename' => ['filename', null],
        'raw_url' => ['raw_url', null],
        'sha' => ['sha', null],
        'status' => ['status', null],
        'patch' => ['patch', null],
        'previous_filename' => ['previous_filename', null],
    ];

    public function __construct(
        public int $additions,
        public string $blob_url,
        public int $changes,
        public string $contents_url,
        public int $deletions,
        public string $filename,
        public string $raw_url,
        public ?string $sha = null,
        public string $status,
        public ?string $patch = null,
        public ?string $previous_filename = null,
    ) {
    }

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'additions' => $this->additions,
            'blob_url' => $this->blob_url,
            'changes' => $this->changes,
            'contents_url' => $this->contents_url,
            'deletions' => $this->deletions,
            'filename' => $this->filename,
            'raw_url' => $this->raw_url,
            'sha' => $this->sha,
            'status' => $this->status,
            'patch' => $this->patch,
            'previous_filename' => $this->previous_filename,
        ];
    }
}
