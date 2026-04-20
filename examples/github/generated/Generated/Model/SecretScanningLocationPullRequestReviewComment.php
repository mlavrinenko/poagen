<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

final readonly class SecretScanningLocationPullRequestReviewComment
{
    public function __construct(
        public string $pull_request_review_comment_url,
        public ?string $html_url = null,
    ) {
    }
}
