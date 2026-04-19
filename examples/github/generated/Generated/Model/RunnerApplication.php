<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

use JsonSerializable;

final readonly class RunnerApplication implements JsonSerializable
{
    /**
     * Paogen marshal/unmarshal contract — phpName => [wireKey, shape]. See ADR-007.
     * @var array<string, array{0: string, 1: null|class-string|array{0: string, 1: null|class-string}|array{0: string, 1: list<class-string>, 2: ?string}}>
     */
    public const array PROPERTY_MAP = [
        'architecture' => ['architecture', null],
        'download_url' => ['download_url', null],
        'filename' => ['filename', null],
        'os' => ['os', null],
        'sha256_checksum' => ['sha256_checksum', null],
        'temp_download_token' => ['temp_download_token', null],
    ];

    public function __construct(
        public string $architecture,
        public string $download_url,
        public string $filename,
        public string $os,
        public ?string $sha256_checksum = null,
        public ?string $temp_download_token = null,
    ) {
    }

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'architecture' => $this->architecture,
            'download_url' => $this->download_url,
            'filename' => $this->filename,
            'os' => $this->os,
            'sha256_checksum' => $this->sha256_checksum,
            'temp_download_token' => $this->temp_download_token,
        ];
    }
}
