<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

final readonly class WebhookPullRequestLockedPull_request_links
{
    public function __construct(
        public WebhookPullRequestLockedPull_request_linksComments $comments,
        public WebhookPullRequestLockedPull_request_linksCommits $commits,
        public WebhookPullRequestLockedPull_request_linksHtml $html,
        public WebhookPullRequestLockedPull_request_linksIssue $issue,
        public WebhookPullRequestLockedPull_request_linksReview_comment $review_comment,
        public WebhookPullRequestLockedPull_request_linksReview_comments $review_comments,
        public WebhookPullRequestLockedPull_request_linksSelf $self,
        public WebhookPullRequestLockedPull_request_linksStatuses $statuses,
    ) {
    }
}
