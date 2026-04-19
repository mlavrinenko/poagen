<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

use JsonSerializable;

final readonly class WebhookPullRequestLabeledPull_request_links implements JsonSerializable
{
    /**
     * Paogen marshal/unmarshal contract — phpName => [wireKey, shape]. See ADR-007.
     * @var array<string, array{0: string, 1: null|class-string|array{0: string, 1: null|class-string}|array{0: string, 1: list<class-string>, 2: ?string}}>
     */
    public const array PROPERTY_MAP = [
        'comments' => ['comments', \Acme\GitHub\Generated\Model\WebhookPullRequestLabeledPull_request_linksComments::class],
        'commits' => ['commits', \Acme\GitHub\Generated\Model\WebhookPullRequestLabeledPull_request_linksCommits::class],
        'html' => ['html', \Acme\GitHub\Generated\Model\WebhookPullRequestLabeledPull_request_linksHtml::class],
        'issue' => ['issue', \Acme\GitHub\Generated\Model\WebhookPullRequestLabeledPull_request_linksIssue::class],
        'review_comment' => [
            'review_comment',
            \Acme\GitHub\Generated\Model\WebhookPullRequestLabeledPull_request_linksReview_comment::class,
        ],
        'review_comments' => [
            'review_comments',
            \Acme\GitHub\Generated\Model\WebhookPullRequestLabeledPull_request_linksReview_comments::class,
        ],
        'self' => ['self', \Acme\GitHub\Generated\Model\WebhookPullRequestLabeledPull_request_linksSelf::class],
        'statuses' => ['statuses', \Acme\GitHub\Generated\Model\WebhookPullRequestLabeledPull_request_linksStatuses::class],
    ];

    public function __construct(
        public WebhookPullRequestLabeledPull_request_linksComments $comments,
        public WebhookPullRequestLabeledPull_request_linksCommits $commits,
        public WebhookPullRequestLabeledPull_request_linksHtml $html,
        public WebhookPullRequestLabeledPull_request_linksIssue $issue,
        public WebhookPullRequestLabeledPull_request_linksReview_comment $review_comment,
        public WebhookPullRequestLabeledPull_request_linksReview_comments $review_comments,
        public WebhookPullRequestLabeledPull_request_linksSelf $self,
        public WebhookPullRequestLabeledPull_request_linksStatuses $statuses,
    ) {
    }

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'comments' => $this->comments,
            'commits' => $this->commits,
            'html' => $this->html,
            'issue' => $this->issue,
            'review_comment' => $this->review_comment,
            'review_comments' => $this->review_comments,
            'self' => $this->self,
            'statuses' => $this->statuses,
        ];
    }
}
