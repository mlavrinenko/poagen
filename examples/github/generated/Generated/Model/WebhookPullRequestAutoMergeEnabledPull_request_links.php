<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

final readonly class WebhookPullRequestAutoMergeEnabledPull_request_links
{
    public function __construct(
        public WebhookPullRequestAutoMergeEnabledPull_request_linksComments $comments,
        public WebhookPullRequestAutoMergeEnabledPull_request_linksCommits $commits,
        public WebhookPullRequestAutoMergeEnabledPull_request_linksHtml $html,
        public WebhookPullRequestAutoMergeEnabledPull_request_linksIssue $issue,
        public WebhookPullRequestAutoMergeEnabledPull_request_linksReview_comment $review_comment,
        public WebhookPullRequestAutoMergeEnabledPull_request_linksReview_comments $review_comments,
        public WebhookPullRequestAutoMergeEnabledPull_request_linksSelf $self,
        public WebhookPullRequestAutoMergeEnabledPull_request_linksStatuses $statuses,
    ) {
    }
}
