<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

final readonly class SecretScanningLocationIssueComment
{
    public function __construct(
        public string $issue_comment_url,
        public ?string $html_url = null,
    ) {
    }
}
