<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

final readonly class WebhookPullRequestDequeuedPull_request_links
{
    public function __construct(
        public WebhookPullRequestDequeuedPull_request_linksComments $comments,
        public WebhookPullRequestDequeuedPull_request_linksCommits $commits,
        public WebhookPullRequestDequeuedPull_request_linksHtml $html,
        public WebhookPullRequestDequeuedPull_request_linksIssue $issue,
        public WebhookPullRequestDequeuedPull_request_linksReview_comment $review_comment,
        public WebhookPullRequestDequeuedPull_request_linksReview_comments $review_comments,
        public WebhookPullRequestDequeuedPull_request_linksSelf $self,
        public WebhookPullRequestDequeuedPull_request_linksStatuses $statuses,
    ) {
    }
}
