<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

final readonly class SecretScanningLocationPullRequestBody
{
    public function __construct(
        public string $pull_request_body_url,
        public ?string $html_url = null,
    ) {
    }
}
