<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

final readonly class WebhookPullRequestReviewRequestRemovedBranch1Pull_request_links
{
    public function __construct(
        public WebhookPullRequestReviewRequestRemovedBranch1Pull_request_linksComments $comments,
        public WebhookPullRequestReviewRequestRemovedBranch1Pull_request_linksCommits $commits,
        public WebhookPullRequestReviewRequestRemovedBranch1Pull_request_linksHtml $html,
        public WebhookPullRequestReviewRequestRemovedBranch1Pull_request_linksIssue $issue,
        public WebhookPullRequestReviewRequestRemovedBranch1Pull_request_linksReview_comment $review_comment,
        public WebhookPullRequestReviewRequestRemovedBranch1Pull_request_linksReview_comments $review_comments,
        public WebhookPullRequestReviewRequestRemovedBranch1Pull_request_linksSelf $self,
        public WebhookPullRequestReviewRequestRemovedBranch1Pull_request_linksStatuses $statuses,
    ) {
    }
}
