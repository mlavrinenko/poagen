<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

final readonly class PullRequestReviewEventReview_links
{
    public function __construct(
        public PullRequestReviewEventReview_linksHtml $html,
        public PullRequestReviewEventReview_linksPull_request $pull_request,
    ) {
    }
}
