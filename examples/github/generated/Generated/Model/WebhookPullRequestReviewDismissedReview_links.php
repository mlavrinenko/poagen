<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

final readonly class WebhookPullRequestReviewDismissedReview_links
{
    public function __construct(
        public WebhookPullRequestReviewDismissedReview_linksHtml $html,
        public WebhookPullRequestReviewDismissedReview_linksPull_request $pull_request,
    ) {
    }
}
