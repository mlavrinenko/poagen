<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

final readonly class WebhooksReviewComment_links
{
    public function __construct(
        public WebhooksReviewComment_linksHtml $html,
        public WebhooksReviewComment_linksPull_request $pull_request,
        public WebhooksReviewComment_linksSelf $self,
    ) {
    }
}
