<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

final readonly class WebhookPullRequestReviewCommentEditedPull_request_links
{
    public function __construct(
        public WebhookPullRequestReviewCommentEditedPull_request_linksComments $comments,
        public WebhookPullRequestReviewCommentEditedPull_request_linksCommits $commits,
        public WebhookPullRequestReviewCommentEditedPull_request_linksHtml $html,
        public WebhookPullRequestReviewCommentEditedPull_request_linksIssue $issue,
        public WebhookPullRequestReviewCommentEditedPull_request_linksReview_comment $review_comment,
        public WebhookPullRequestReviewCommentEditedPull_request_linksReview_comments $review_comments,
        public WebhookPullRequestReviewCommentEditedPull_request_linksSelf $self,
        public WebhookPullRequestReviewCommentEditedPull_request_linksStatuses $statuses,
    ) {
    }
}
