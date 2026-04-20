<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

final readonly class WebhookPullRequestReviewCommentCreatedPull_request_links
{
    public function __construct(
        public WebhookPullRequestReviewCommentCreatedPull_request_linksComments $comments,
        public WebhookPullRequestReviewCommentCreatedPull_request_linksCommits $commits,
        public WebhookPullRequestReviewCommentCreatedPull_request_linksHtml $html,
        public WebhookPullRequestReviewCommentCreatedPull_request_linksIssue $issue,
        public WebhookPullRequestReviewCommentCreatedPull_request_linksReview_comment $review_comment,
        public WebhookPullRequestReviewCommentCreatedPull_request_linksReview_comments $review_comments,
        public WebhookPullRequestReviewCommentCreatedPull_request_linksSelf $self,
        public WebhookPullRequestReviewCommentCreatedPull_request_linksStatuses $statuses,
    ) {
    }
}
