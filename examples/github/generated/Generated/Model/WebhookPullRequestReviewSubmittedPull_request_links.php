<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

final readonly class WebhookPullRequestReviewSubmittedPull_request_links
{
    public function __construct(
        public WebhookPullRequestReviewSubmittedPull_request_linksComments $comments,
        public WebhookPullRequestReviewSubmittedPull_request_linksCommits $commits,
        public WebhookPullRequestReviewSubmittedPull_request_linksHtml $html,
        public WebhookPullRequestReviewSubmittedPull_request_linksIssue $issue,
        public WebhookPullRequestReviewSubmittedPull_request_linksReview_comment $review_comment,
        public WebhookPullRequestReviewSubmittedPull_request_linksReview_comments $review_comments,
        public WebhookPullRequestReviewSubmittedPull_request_linksSelf $self,
        public WebhookPullRequestReviewSubmittedPull_request_linksStatuses $statuses,
    ) {
    }
}
