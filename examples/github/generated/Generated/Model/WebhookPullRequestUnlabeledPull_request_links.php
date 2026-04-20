<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

final readonly class WebhookPullRequestUnlabeledPull_request_links
{
    public function __construct(
        public WebhookPullRequestUnlabeledPull_request_linksComments $comments,
        public WebhookPullRequestUnlabeledPull_request_linksCommits $commits,
        public WebhookPullRequestUnlabeledPull_request_linksHtml $html,
        public WebhookPullRequestUnlabeledPull_request_linksIssue $issue,
        public WebhookPullRequestUnlabeledPull_request_linksReview_comment $review_comment,
        public WebhookPullRequestUnlabeledPull_request_linksReview_comments $review_comments,
        public WebhookPullRequestUnlabeledPull_request_linksSelf $self,
        public WebhookPullRequestUnlabeledPull_request_linksStatuses $statuses,
    ) {
    }
}
