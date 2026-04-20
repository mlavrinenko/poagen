<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

final readonly class PullRequestReviewCommentEventComment_links
{
    public function __construct(
        public PullRequestReviewCommentEventComment_linksHtml $html,
        public PullRequestReviewCommentEventComment_linksPull_request $pull_request,
        public PullRequestReviewCommentEventComment_linksSelf $self,
    ) {
    }
}
