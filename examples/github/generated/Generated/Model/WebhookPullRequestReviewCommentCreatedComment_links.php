<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

final readonly class WebhookPullRequestReviewCommentCreatedComment_links
{
    public function __construct(
        public WebhookPullRequestReviewCommentCreatedComment_linksHtml $html,
        public WebhookPullRequestReviewCommentCreatedComment_linksPull_request $pull_request,
        public WebhookPullRequestReviewCommentCreatedComment_linksSelf $self,
    ) {
    }
}
