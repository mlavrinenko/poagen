<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

final readonly class SecretScanningLocationIssueTitle
{
    public function __construct(
        public string $issue_title_url,
        public ?string $html_url = null,
    ) {
    }
}
