<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

final readonly class PullRequestReviewComment_links
{
    public function __construct(
        public PullRequestReviewComment_linksHtml $html,
        public PullRequestReviewComment_linksPull_request $pull_request,
        public PullRequestReviewComment_linksSelf $self,
    ) {
    }
}
