<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

final readonly class SecretScanningLocationIssueBody implements NullableSecretScanningFirstDetectedLocation
{
    public function __construct(
        public string $issue_body_url,
        public ?string $html_url = null,
    ) {
    }
}
