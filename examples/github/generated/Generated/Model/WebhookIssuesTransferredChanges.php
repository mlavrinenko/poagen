<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

use JsonSerializable;

final readonly class WebhookIssuesTransferredChanges implements JsonSerializable
{
    /**
     * Paogen marshal/unmarshal contract — phpName => [wireKey, shape]. See ADR-007.
     * @var array<string, array{0: string, 1: null|class-string|array{0: string, 1: null|class-string}|array{0: string, 1: list<class-string>, 2: ?string}}>
     */
    public const array PROPERTY_MAP = [
        'new_issue' => ['new_issue', \Acme\GitHub\Generated\Model\WebhookIssuesTransferredChangesNew_issue::class],
        'new_repository' => [
            'new_repository',
            \Acme\GitHub\Generated\Model\WebhookIssuesTransferredChangesNew_repository::class,
        ],
    ];

    public function __construct(
        public WebhookIssuesTransferredChangesNew_issue $new_issue,
        public WebhookIssuesTransferredChangesNew_repository $new_repository,
    ) {
    }

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'new_issue' => $this->new_issue,
            'new_repository' => $this->new_repository,
        ];
    }
}
