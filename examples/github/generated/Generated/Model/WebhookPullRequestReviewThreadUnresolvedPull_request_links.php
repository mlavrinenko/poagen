<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

final readonly class WebhookPullRequestReviewThreadUnresolvedPull_request_links
{
    public function __construct(
        public WebhookPullRequestReviewThreadUnresolvedPull_request_linksComments $comments,
        public WebhookPullRequestReviewThreadUnresolvedPull_request_linksCommits $commits,
        public WebhookPullRequestReviewThreadUnresolvedPull_request_linksHtml $html,
        public WebhookPullRequestReviewThreadUnresolvedPull_request_linksIssue $issue,
        public WebhookPullRequestReviewThreadUnresolvedPull_request_linksReview_comment $review_comment,
        public WebhookPullRequestReviewThreadUnresolvedPull_request_linksReview_comments $review_comments,
        public WebhookPullRequestReviewThreadUnresolvedPull_request_linksSelf $self,
        public WebhookPullRequestReviewThreadUnresolvedPull_request_linksStatuses $statuses,
    ) {
    }
}
