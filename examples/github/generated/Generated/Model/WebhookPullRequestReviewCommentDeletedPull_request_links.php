<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

final readonly class WebhookPullRequestReviewCommentDeletedPull_request_links
{
    public function __construct(
        public WebhookPullRequestReviewCommentDeletedPull_request_linksComments $comments,
        public WebhookPullRequestReviewCommentDeletedPull_request_linksCommits $commits,
        public WebhookPullRequestReviewCommentDeletedPull_request_linksHtml $html,
        public WebhookPullRequestReviewCommentDeletedPull_request_linksIssue $issue,
        public WebhookPullRequestReviewCommentDeletedPull_request_linksReview_comment $review_comment,
        public WebhookPullRequestReviewCommentDeletedPull_request_linksReview_comments $review_comments,
        public WebhookPullRequestReviewCommentDeletedPull_request_linksSelf $self,
        public WebhookPullRequestReviewCommentDeletedPull_request_linksStatuses $statuses,
    ) {
    }
}
