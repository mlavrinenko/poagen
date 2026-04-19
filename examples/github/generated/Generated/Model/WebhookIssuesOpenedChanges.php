<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

use JsonSerializable;

final readonly class WebhookIssuesOpenedChanges implements JsonSerializable
{
    /**
     * Paogen marshal/unmarshal contract — phpName => [wireKey, shape]. See ADR-007.
     * @var array<string, array{0: string, 1: null|class-string|array{0: string, 1: null|class-string}|array{0: string, 1: list<class-string>, 2: ?string}}>
     */
    public const array PROPERTY_MAP = [
        'old_issue' => ['old_issue', \Acme\GitHub\Generated\Model\WebhookIssuesOpenedChangesOld_issue::class],
        'old_repository' => [
            'old_repository',
            \Acme\GitHub\Generated\Model\WebhookIssuesOpenedChangesOld_repository::class,
        ],
    ];

    public function __construct(
        public WebhookIssuesOpenedChangesOld_issue $old_issue,
        public WebhookIssuesOpenedChangesOld_repository $old_repository,
    ) {
    }

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'old_issue' => $this->old_issue,
            'old_repository' => $this->old_repository,
        ];
    }
}
