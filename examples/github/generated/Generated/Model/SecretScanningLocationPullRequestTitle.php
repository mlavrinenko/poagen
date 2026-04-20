<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

final readonly class SecretScanningLocationPullRequestTitle implements NullableSecretScanningFirstDetectedLocation
{
    public function __construct(
        public string $pull_request_title_url,
        public ?string $html_url = null,
    ) {
    }
}
