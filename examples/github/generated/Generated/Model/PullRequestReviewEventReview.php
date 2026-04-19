<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

use JsonSerializable;

final readonly class PullRequestReviewEventReview implements JsonSerializable
{
    /**
     * Paogen marshal/unmarshal contract — phpName => [wireKey, shape]. See ADR-007.
     * @var array<string, array{0: string, 1: null|class-string|array{0: string, 1: null|class-string}|array{0: string, 1: list<class-string>, 2: ?string}}>
     */
    public const array PROPERTY_MAP = [
        '_links' => ['_links', \Acme\GitHub\Generated\Model\PullRequestReviewEventReview_links::class],
        'body' => ['body', null],
        'commit_id' => ['commit_id', null],
        'html_url' => ['html_url', null],
        'id' => ['id', null],
        'node_id' => ['node_id', null],
        'pull_request_url' => ['pull_request_url', null],
        'state' => ['state', null],
        'submitted_at' => ['submitted_at', null],
        'updated_at' => ['updated_at', null],
        'user' => ['user', \Acme\GitHub\Generated\Model\NullableSimpleUser::class],
    ];

    public function __construct(
        public ?PullRequestReviewEventReview_links $_links = null,
        public ?string $body = null,
        public ?string $commit_id = null,
        public ?string $html_url = null,
        public ?int $id = null,
        public ?string $node_id = null,
        public ?string $pull_request_url = null,
        public ?string $state = null,
        public ?string $submitted_at = null,
        public ?string $updated_at = null,
        public ?NullableSimpleUser $user = null,
    ) {
    }

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            '_links' => $this->_links,
            'body' => $this->body,
            'commit_id' => $this->commit_id,
            'html_url' => $this->html_url,
            'id' => $this->id,
            'node_id' => $this->node_id,
            'pull_request_url' => $this->pull_request_url,
            'state' => $this->state,
            'submitted_at' => $this->submitted_at,
            'updated_at' => $this->updated_at,
            'user' => $this->user,
        ];
    }
}
