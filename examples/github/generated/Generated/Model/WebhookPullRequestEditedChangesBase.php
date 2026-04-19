<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

use JsonSerializable;

final readonly class WebhookPullRequestEditedChangesBase implements JsonSerializable
{
    /**
     * Paogen marshal/unmarshal contract — phpName => [wireKey, shape]. See ADR-007.
     * @var array<string, array{0: string, 1: null|class-string|array{0: string, 1: null|class-string}|array{0: string, 1: list<class-string>, 2: ?string}}>
     */
    public const array PROPERTY_MAP = [
        'ref' => ['ref', \Acme\GitHub\Generated\Model\WebhookPullRequestEditedChangesBaseRef::class],
        'sha' => ['sha', \Acme\GitHub\Generated\Model\WebhookPullRequestEditedChangesBaseSha::class],
    ];

    public function __construct(
        public WebhookPullRequestEditedChangesBaseRef $ref,
        public WebhookPullRequestEditedChangesBaseSha $sha,
    ) {
    }

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'ref' => $this->ref,
            'sha' => $this->sha,
        ];
    }
}
