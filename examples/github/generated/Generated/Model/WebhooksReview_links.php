<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

final readonly class WebhooksReview_links
{
    public function __construct(
        public WebhooksReview_linksHtml $html,
        public WebhooksReview_linksPull_request $pull_request,
    ) {
    }
}
