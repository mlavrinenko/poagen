<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

final readonly class WebhookPullRequestUnlockedPull_request_links
{
    public function __construct(
        public WebhookPullRequestUnlockedPull_request_linksComments $comments,
        public WebhookPullRequestUnlockedPull_request_linksCommits $commits,
        public WebhookPullRequestUnlockedPull_request_linksHtml $html,
        public WebhookPullRequestUnlockedPull_request_linksIssue $issue,
        public WebhookPullRequestUnlockedPull_request_linksReview_comment $review_comment,
        public WebhookPullRequestUnlockedPull_request_linksReview_comments $review_comments,
        public WebhookPullRequestUnlockedPull_request_linksSelf $self,
        public WebhookPullRequestUnlockedPull_request_linksStatuses $statuses,
    ) {
    }
}
