<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

use JsonSerializable;

final readonly class WebhookDiscussionTransferredChanges implements JsonSerializable
{
    /**
     * Paogen marshal/unmarshal contract — phpName => [wireKey, shape]. See ADR-007.
     * @var array<string, array{0: string, 1: null|class-string|array{0: string, 1: null|class-string}|array{0: string, 1: list<class-string>, 2: ?string}}>
     */
    public const array PROPERTY_MAP = [
        'new_discussion' => ['new_discussion', \Acme\GitHub\Generated\Model\Discussion::class],
        'new_repository' => ['new_repository', \Acme\GitHub\Generated\Model\RepositoryWebhooks::class],
    ];

    public function __construct(
        public Discussion $new_discussion,
        public RepositoryWebhooks $new_repository,
    ) {
    }

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'new_discussion' => $this->new_discussion,
            'new_repository' => $this->new_repository,
        ];
    }
}
