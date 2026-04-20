<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

final readonly class WebhookPullRequestEnqueuedPull_request_links
{
    public function __construct(
        public WebhookPullRequestEnqueuedPull_request_linksComments $comments,
        public WebhookPullRequestEnqueuedPull_request_linksCommits $commits,
        public WebhookPullRequestEnqueuedPull_request_linksHtml $html,
        public WebhookPullRequestEnqueuedPull_request_linksIssue $issue,
        public WebhookPullRequestEnqueuedPull_request_linksReview_comment $review_comment,
        public WebhookPullRequestEnqueuedPull_request_linksReview_comments $review_comments,
        public WebhookPullRequestEnqueuedPull_request_linksSelf $self,
        public WebhookPullRequestEnqueuedPull_request_linksStatuses $statuses,
    ) {
    }
}
