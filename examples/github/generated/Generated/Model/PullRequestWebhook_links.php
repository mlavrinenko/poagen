<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

use JsonSerializable;

final readonly class PullRequestWebhook_links implements JsonSerializable
{
    /**
     * Paogen marshal/unmarshal contract — phpName => [wireKey, shape]. See ADR-007.
     * @var array<string, array{0: string, 1: null|class-string|array{0: string, 1: null|class-string}|array{0: string, 1: list<class-string>, 2: ?string}}>
     */
    public const array PROPERTY_MAP = [
        'comments' => ['comments', \Acme\GitHub\Generated\Model\Link::class],
        'commits' => ['commits', \Acme\GitHub\Generated\Model\Link::class],
        'html' => ['html', \Acme\GitHub\Generated\Model\Link::class],
        'issue' => ['issue', \Acme\GitHub\Generated\Model\Link::class],
        'review_comment' => ['review_comment', \Acme\GitHub\Generated\Model\Link::class],
        'review_comments' => ['review_comments', \Acme\GitHub\Generated\Model\Link::class],
        'self' => ['self', \Acme\GitHub\Generated\Model\Link::class],
        'statuses' => ['statuses', \Acme\GitHub\Generated\Model\Link::class],
    ];

    public function __construct(
        public Link $comments,
        public Link $commits,
        public Link $html,
        public Link $issue,
        public Link $review_comment,
        public Link $review_comments,
        public Link $self,
        public Link $statuses,
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
