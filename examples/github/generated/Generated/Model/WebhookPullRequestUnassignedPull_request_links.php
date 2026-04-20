<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

final readonly class WebhookPullRequestUnassignedPull_request_links
{
    public function __construct(
        public WebhookPullRequestUnassignedPull_request_linksComments $comments,
        public WebhookPullRequestUnassignedPull_request_linksCommits $commits,
        public WebhookPullRequestUnassignedPull_request_linksHtml $html,
        public WebhookPullRequestUnassignedPull_request_linksIssue $issue,
        public WebhookPullRequestUnassignedPull_request_linksReview_comment $review_comment,
        public WebhookPullRequestUnassignedPull_request_linksReview_comments $review_comments,
        public WebhookPullRequestUnassignedPull_request_linksSelf $self,
        public WebhookPullRequestUnassignedPull_request_linksStatuses $statuses,
    ) {
    }
}
