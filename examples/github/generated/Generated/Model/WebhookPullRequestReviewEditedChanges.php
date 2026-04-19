<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

use JsonSerializable;

final readonly class WebhookPullRequestReviewEditedChanges implements JsonSerializable
{
    /**
     * Paogen marshal/unmarshal contract — phpName => [wireKey, shape]. See ADR-007.
     * @var array<string, array{0: string, 1: null|class-string|array{0: string, 1: null|class-string}|array{0: string, 1: list<class-string>, 2: ?string}}>
     */
    public const array PROPERTY_MAP = [
        'body' => ['body', \Acme\GitHub\Generated\Model\WebhookPullRequestReviewEditedChangesBody::class],
    ];

    public function __construct(
        public ?WebhookPullRequestReviewEditedChangesBody $body = null,
    ) {
    }

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'body' => $this->body,
        ];
    }
}
