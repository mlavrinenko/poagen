<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

final readonly class SecretScanningLocationCommit implements NullableSecretScanningFirstDetectedLocation
{
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
}
