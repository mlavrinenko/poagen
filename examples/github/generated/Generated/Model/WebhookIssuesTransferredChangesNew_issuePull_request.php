<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

use DateTimeImmutable;

final readonly class WebhookIssuesTransferredChangesNew_issuePull_request
{
    public function __construct(
        public ?string $diff_url = null,
        public ?string $html_url = null,
        public ?DateTimeImmutable $merged_at = null,
        public ?string $patch_url = null,
        public ?string $url = null,
    ) {
    }
}
