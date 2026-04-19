<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

use JsonSerializable;

final readonly class SecretScanningLocationCommit implements JsonSerializable
{
    /**
     * Paogen marshal/unmarshal contract — phpName => [wireKey, shape]. See ADR-007.
     * @var array<string, array{0: string, 1: null|class-string|array{0: string, 1: null|class-string}|array{0: string, 1: list<class-string>, 2: ?string}}>
     */
    public const array PROPERTY_MAP = [
        'blob_sha' => ['blob_sha', null],
        'blob_url' => ['blob_url', null],
        'commit_sha' => ['commit_sha', null],
        'commit_url' => ['commit_url', null],
        'end_column' => ['end_column', null],
        'end_line' => ['end_line', null],
        'path' => ['path', null],
        'start_column' => ['start_column', null],
        'start_line' => ['start_line', null],
        'html_url' => ['html_url', null],
    ];

    public function __construct(
        public string $blob_sha,
        public string $blob_url,
        public string $commit_sha,
        public string $commit_url,
        public float $end_column,
        public float $end_line,
        public string $path,
        public float $start_column,
        public float $start_line,
        public ?string $html_url = null,
    ) {
    }

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'blob_sha' => $this->blob_sha,
            'blob_url' => $this->blob_url,
            'commit_sha' => $this->commit_sha,
            'commit_url' => $this->commit_url,
            'end_column' => $this->end_column,
            'end_line' => $this->end_line,
            'path' => $this->path,
            'start_column' => $this->start_column,
            'start_line' => $this->start_line,
            'html_url' => $this->html_url,
        ];
    }
}
