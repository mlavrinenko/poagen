<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

final readonly class WebhookPullRequestReviewThreadResolvedPull_request_links
{
    public function __construct(
        public WebhookPullRequestReviewThreadResolvedPull_request_linksComments $comments,
        public WebhookPullRequestReviewThreadResolvedPull_request_linksCommits $commits,
        public WebhookPullRequestReviewThreadResolvedPull_request_linksHtml $html,
        public WebhookPullRequestReviewThreadResolvedPull_request_linksIssue $issue,
        public WebhookPullRequestReviewThreadResolvedPull_request_linksReview_comment $review_comment,
        public WebhookPullRequestReviewThreadResolvedPull_request_linksReview_comments $review_comments,
        public WebhookPullRequestReviewThreadResolvedPull_request_linksSelf $self,
        public WebhookPullRequestReviewThreadResolvedPull_request_linksStatuses $statuses,
    ) {
    }
}
