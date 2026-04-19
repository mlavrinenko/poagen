<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

use JsonSerializable;

final readonly class WebhookPullRequestReviewThreadUnresolvedPull_requestHead implements JsonSerializable
{
    /**
     * Paogen marshal/unmarshal contract — phpName => [wireKey, shape]. See ADR-007.
     * @var array<string, array{0: string, 1: null|class-string|array{0: string, 1: null|class-string}|array{0: string, 1: list<class-string>, 2: ?string}}>
     */
    public const array PROPERTY_MAP = [
        'label' => ['label', null],
        'ref' => ['ref', null],
        'repo' => [
            'repo',
            \Acme\GitHub\Generated\Model\WebhookPullRequestReviewThreadUnresolvedPull_requestHeadRepo::class,
        ],
        'sha' => ['sha', null],
        'user' => [
            'user',
            \Acme\GitHub\Generated\Model\WebhookPullRequestReviewThreadUnresolvedPull_requestHeadUser::class,
        ],
    ];

    public function __construct(
        public string $label,
        public string $ref,
        public WebhookPullRequestReviewThreadUnresolvedPull_requestHeadRepo $repo,
        public string $sha,
        public WebhookPullRequestReviewThreadUnresolvedPull_requestHeadUser $user,
    ) {
    }

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'label' => $this->label,
            'ref' => $this->ref,
            'repo' => $this->repo,
            'sha' => $this->sha,
            'user' => $this->user,
        ];
    }
}
