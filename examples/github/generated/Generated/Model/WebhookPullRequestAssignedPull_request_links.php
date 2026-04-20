<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

final readonly class WebhookPullRequestAssignedPull_request_links
{
    public function __construct(
        public WebhookPullRequestAssignedPull_request_linksComments $comments,
        public WebhookPullRequestAssignedPull_request_linksCommits $commits,
        public WebhookPullRequestAssignedPull_request_linksHtml $html,
        public WebhookPullRequestAssignedPull_request_linksIssue $issue,
        public WebhookPullRequestAssignedPull_request_linksReview_comment $review_comment,
        public WebhookPullRequestAssignedPull_request_linksReview_comments $review_comments,
        public WebhookPullRequestAssignedPull_request_linksSelf $self,
        public WebhookPullRequestAssignedPull_request_linksStatuses $statuses,
    ) {
    }
}
