<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

use JsonSerializable;

final readonly class SecretScanningLocation implements JsonSerializable
{
    /**
     * Paogen marshal/unmarshal contract — phpName => [wireKey, shape]. See ADR-007.
     * @var array<string, array{0: string, 1: null|class-string|array{0: string, 1: null|class-string}|array{0: string, 1: list<class-string>, 2: ?string}}>
     */
    public const array PROPERTY_MAP = [
        'details' => [
            'details',
            [
                'union',
                [
                    \Acme\GitHub\Generated\Model\SecretScanningLocationCommit::class,
                    \Acme\GitHub\Generated\Model\SecretScanningLocationWikiCommit::class,
                    \Acme\GitHub\Generated\Model\SecretScanningLocationIssueTitle::class,
                    \Acme\GitHub\Generated\Model\SecretScanningLocationIssueBody::class,
                    \Acme\GitHub\Generated\Model\SecretScanningLocationIssueComment::class,
                    \Acme\GitHub\Generated\Model\SecretScanningLocationDiscussionTitle::class,
                    \Acme\GitHub\Generated\Model\SecretScanningLocationDiscussionBody::class,
                    \Acme\GitHub\Generated\Model\SecretScanningLocationDiscussionComment::class,
                    \Acme\GitHub\Generated\Model\SecretScanningLocationPullRequestTitle::class,
                    \Acme\GitHub\Generated\Model\SecretScanningLocationPullRequestBody::class,
                    \Acme\GitHub\Generated\Model\SecretScanningLocationPullRequestComment::class,
                    \Acme\GitHub\Generated\Model\SecretScanningLocationPullRequestReview::class,
                    \Acme\GitHub\Generated\Model\SecretScanningLocationPullRequestReviewComment::class,
                ],
                null,
            ],
        ],
        'type' => ['type', null],
    ];

    public function __construct(
        public SecretScanningLocationCommit|SecretScanningLocationWikiCommit|SecretScanningLocationIssueTitle|SecretScanningLocationIssueBody|SecretScanningLocationIssueComment|SecretScanningLocationDiscussionTitle|SecretScanningLocationDiscussionBody|SecretScanningLocationDiscussionComment|SecretScanningLocationPullRequestTitle|SecretScanningLocationPullRequestBody|SecretScanningLocationPullRequestComment|SecretScanningLocationPullRequestReview|SecretScanningLocationPullRequestReviewComment|null $details = null,
        public ?string $type = null,
    ) {
    }

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'details' => $this->details,
            'type' => $this->type,
        ];
    }
}
