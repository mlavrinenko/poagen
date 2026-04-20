<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

final readonly class WebhookPullRequestReviewRequestedBranch2Pull_request_links
{
    public function __construct(
        public WebhookPullRequestReviewRequestedBranch2Pull_request_linksComments $comments,
        public WebhookPullRequestReviewRequestedBranch2Pull_request_linksCommits $commits,
        public WebhookPullRequestReviewRequestedBranch2Pull_request_linksHtml $html,
        public WebhookPullRequestReviewRequestedBranch2Pull_request_linksIssue $issue,
        public WebhookPullRequestReviewRequestedBranch2Pull_request_linksReview_comment $review_comment,
        public WebhookPullRequestReviewRequestedBranch2Pull_request_linksReview_comments $review_comments,
        public WebhookPullRequestReviewRequestedBranch2Pull_request_linksSelf $self,
        public WebhookPullRequestReviewRequestedBranch2Pull_request_linksStatuses $statuses,
    ) {
    }
}
