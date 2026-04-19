<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

use JsonSerializable;

final readonly class WebhookDiscussionEditedChanges implements JsonSerializable
{
    /**
     * Paogen marshal/unmarshal contract — phpName => [wireKey, shape]. See ADR-007.
     * @var array<string, array{0: string, 1: null|class-string|array{0: string, 1: null|class-string}|array{0: string, 1: list<class-string>, 2: ?string}}>
     */
    public const array PROPERTY_MAP = [
        'body' => ['body', \Acme\GitHub\Generated\Model\WebhookDiscussionEditedChangesBody::class],
        'title' => ['title', \Acme\GitHub\Generated\Model\WebhookDiscussionEditedChangesTitle::class],
    ];

    public function __construct(
        public ?WebhookDiscussionEditedChangesBody $body = null,
        public ?WebhookDiscussionEditedChangesTitle $title = null,
    ) {
    }

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'body' => $this->body,
            'title' => $this->title,
        ];
    }
}
