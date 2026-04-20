<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

final readonly class WebhookIssuesTransferredChanges
{
    public function __construct(
        public WebhookIssuesTransferredChangesNew_issue $new_issue,
        public WebhookIssuesTransferredChangesNew_repository $new_repository,
    ) {
    }
}
