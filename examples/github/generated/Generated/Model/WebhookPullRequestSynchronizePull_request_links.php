<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

final readonly class WebhookPullRequestSynchronizePull_request_links
{
    public function __construct(
        public WebhookPullRequestSynchronizePull_request_linksComments $comments,
        public WebhookPullRequestSynchronizePull_request_linksCommits $commits,
        public WebhookPullRequestSynchronizePull_request_linksHtml $html,
        public WebhookPullRequestSynchronizePull_request_linksIssue $issue,
        public WebhookPullRequestSynchronizePull_request_linksReview_comment $review_comment,
        public WebhookPullRequestSynchronizePull_request_linksReview_comments $review_comments,
        public WebhookPullRequestSynchronizePull_request_linksSelf $self,
        public WebhookPullRequestSynchronizePull_request_linksStatuses $statuses,
    ) {
    }
}
