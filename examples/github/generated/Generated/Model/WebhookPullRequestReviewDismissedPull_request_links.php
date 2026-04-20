<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

final readonly class WebhookPullRequestReviewDismissedPull_request_links
{
    public function __construct(
        public WebhookPullRequestReviewDismissedPull_request_linksComments $comments,
        public WebhookPullRequestReviewDismissedPull_request_linksCommits $commits,
        public WebhookPullRequestReviewDismissedPull_request_linksHtml $html,
        public WebhookPullRequestReviewDismissedPull_request_linksIssue $issue,
        public WebhookPullRequestReviewDismissedPull_request_linksReview_comment $review_comment,
        public WebhookPullRequestReviewDismissedPull_request_linksReview_comments $review_comments,
        public WebhookPullRequestReviewDismissedPull_request_linksSelf $self,
        public WebhookPullRequestReviewDismissedPull_request_linksStatuses $statuses,
    ) {
    }
}
