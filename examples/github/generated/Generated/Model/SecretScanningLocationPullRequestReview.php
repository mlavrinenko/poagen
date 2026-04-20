<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

final readonly class SecretScanningLocationPullRequestReview
{
    public function __construct(
        public string $pull_request_review_url,
        public ?string $html_url = null,
    ) {
    }
}
