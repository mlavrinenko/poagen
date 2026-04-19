<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

use JsonSerializable;

final readonly class WebhookPullRequestEditedChanges implements JsonSerializable
{
    /**
     * Paogen marshal/unmarshal contract — phpName => [wireKey, shape]. See ADR-007.
     * @var array<string, array{0: string, 1: null|class-string|array{0: string, 1: null|class-string}|array{0: string, 1: list<class-string>, 2: ?string}}>
     */
    public const array PROPERTY_MAP = [
        'base' => ['base', \Acme\GitHub\Generated\Model\WebhookPullRequestEditedChangesBase::class],
        'body' => ['body', \Acme\GitHub\Generated\Model\WebhookPullRequestEditedChangesBody::class],
        'title' => ['title', \Acme\GitHub\Generated\Model\WebhookPullRequestEditedChangesTitle::class],
    ];

    public function __construct(
        public ?WebhookPullRequestEditedChangesBase $base = null,
        public ?WebhookPullRequestEditedChangesBody $body = null,
        public ?WebhookPullRequestEditedChangesTitle $title = null,
    ) {
    }

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'base' => $this->base,
            'body' => $this->body,
            'title' => $this->title,
        ];
    }
}
