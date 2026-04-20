<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

final readonly class WebhookPullRequestLabeledPull_request_links
{
    public function __construct(
        public WebhookPullRequestLabeledPull_request_linksComments $comments,
        public WebhookPullRequestLabeledPull_request_linksCommits $commits,
        public WebhookPullRequestLabeledPull_request_linksHtml $html,
        public WebhookPullRequestLabeledPull_request_linksIssue $issue,
        public WebhookPullRequestLabeledPull_request_linksReview_comment $review_comment,
        public WebhookPullRequestLabeledPull_request_linksReview_comments $review_comments,
        public WebhookPullRequestLabeledPull_request_linksSelf $self,
        public WebhookPullRequestLabeledPull_request_linksStatuses $statuses,
    ) {
    }
}
