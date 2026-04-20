<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

final readonly class WebhookIssuesOpenedChanges
{
    public function __construct(
        public WebhookIssuesOpenedChangesOld_issue $old_issue,
        public WebhookIssuesOpenedChangesOld_repository $old_repository,
    ) {
    }
}
