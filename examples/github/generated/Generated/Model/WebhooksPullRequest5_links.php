<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

final readonly class WebhooksPullRequest5_links
{
    public function __construct(
        public WebhooksPullRequest5_linksComments $comments,
        public WebhooksPullRequest5_linksCommits $commits,
        public WebhooksPullRequest5_linksHtml $html,
        public WebhooksPullRequest5_linksIssue $issue,
        public WebhooksPullRequest5_linksReview_comment $review_comment,
        public WebhooksPullRequest5_linksReview_comments $review_comments,
        public WebhooksPullRequest5_linksSelf $self,
        public WebhooksPullRequest5_linksStatuses $statuses,
    ) {
    }
}
