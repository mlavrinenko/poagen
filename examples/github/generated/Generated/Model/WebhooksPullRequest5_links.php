<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

use JsonSerializable;

final readonly class WebhooksPullRequest5_links implements JsonSerializable
{
    /**
     * Paogen marshal/unmarshal contract — phpName => [wireKey, shape]. See ADR-007.
     * @var array<string, array{0: string, 1: null|class-string|array{0: string, 1: null|class-string}|array{0: string, 1: list<class-string>, 2: ?string}}>
     */
    public const array PROPERTY_MAP = [
        'comments' => ['comments', \Acme\GitHub\Generated\Model\WebhooksPullRequest5_linksComments::class],
        'commits' => ['commits', \Acme\GitHub\Generated\Model\WebhooksPullRequest5_linksCommits::class],
        'html' => ['html', \Acme\GitHub\Generated\Model\WebhooksPullRequest5_linksHtml::class],
        'issue' => ['issue', \Acme\GitHub\Generated\Model\WebhooksPullRequest5_linksIssue::class],
        'review_comment' => [
            'review_comment',
            \Acme\GitHub\Generated\Model\WebhooksPullRequest5_linksReview_comment::class,
        ],
        'review_comments' => [
            'review_comments',
            \Acme\GitHub\Generated\Model\WebhooksPullRequest5_linksReview_comments::class,
        ],
        'self' => ['self', \Acme\GitHub\Generated\Model\WebhooksPullRequest5_linksSelf::class],
        'statuses' => ['statuses', \Acme\GitHub\Generated\Model\WebhooksPullRequest5_linksStatuses::class],
    ];

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
