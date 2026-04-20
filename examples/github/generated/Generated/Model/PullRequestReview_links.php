<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

final readonly class PullRequestReview_links
{
    public function __construct(
        public PullRequestReview_linksHtml $html,
        public PullRequestReview_linksPull_request $pull_request,
    ) {
    }
}
