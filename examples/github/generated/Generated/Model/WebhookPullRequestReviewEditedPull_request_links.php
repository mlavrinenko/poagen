<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

final readonly class WebhookPullRequestReviewEditedPull_request_links
{
    public function __construct(
        public WebhookPullRequestReviewEditedPull_request_linksComments $comments,
        public WebhookPullRequestReviewEditedPull_request_linksCommits $commits,
        public WebhookPullRequestReviewEditedPull_request_linksHtml $html,
        public WebhookPullRequestReviewEditedPull_request_linksIssue $issue,
        public WebhookPullRequestReviewEditedPull_request_linksReview_comment $review_comment,
        public WebhookPullRequestReviewEditedPull_request_linksReview_comments $review_comments,
        public WebhookPullRequestReviewEditedPull_request_linksSelf $self,
        public WebhookPullRequestReviewEditedPull_request_linksStatuses $statuses,
    ) {
    }
}
