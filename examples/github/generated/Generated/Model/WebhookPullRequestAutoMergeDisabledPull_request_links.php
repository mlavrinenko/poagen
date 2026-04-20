<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

final readonly class WebhookPullRequestAutoMergeDisabledPull_request_links
{
    public function __construct(
        public WebhookPullRequestAutoMergeDisabledPull_request_linksComments $comments,
        public WebhookPullRequestAutoMergeDisabledPull_request_linksCommits $commits,
        public WebhookPullRequestAutoMergeDisabledPull_request_linksHtml $html,
        public WebhookPullRequestAutoMergeDisabledPull_request_linksIssue $issue,
        public WebhookPullRequestAutoMergeDisabledPull_request_linksReview_comment $review_comment,
        public WebhookPullRequestAutoMergeDisabledPull_request_linksReview_comments $review_comments,
        public WebhookPullRequestAutoMergeDisabledPull_request_linksSelf $self,
        public WebhookPullRequestAutoMergeDisabledPull_request_linksStatuses $statuses,
    ) {
    }
}
