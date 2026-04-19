<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

use JsonSerializable;

final readonly class WebhookDiscussionUnanswered implements JsonSerializable
{
    /**
     * Paogen marshal/unmarshal contract — phpName => [wireKey, shape]. See ADR-007.
     * @var array<string, array{0: string, 1: null|class-string|array{0: string, 1: null|class-string}|array{0: string, 1: list<class-string>, 2: ?string}}>
     */
    public const array PROPERTY_MAP = [
        'action' => ['action', null],
        'discussion' => ['discussion', \Acme\GitHub\Generated\Model\Discussion::class],
        'old_answer' => ['old_answer', \Acme\GitHub\Generated\Model\WebhooksAnswer::class],
        'repository' => ['repository', \Acme\GitHub\Generated\Model\RepositoryWebhooks::class],
        'organization' => ['organization', \Acme\GitHub\Generated\Model\OrganizationSimpleWebhooks::class],
        'sender' => ['sender', \Acme\GitHub\Generated\Model\SimpleUser::class],
    ];

    public function __construct(
        public string $action,
        public Discussion $discussion,
        public WebhooksAnswer $old_answer,
        public RepositoryWebhooks $repository,
        public ?OrganizationSimpleWebhooks $organization = null,
        public ?SimpleUser $sender = null,
    ) {
    }

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'action' => $this->action,
            'discussion' => $this->discussion,
            'old_answer' => $this->old_answer,
            'repository' => $this->repository,
            'organization' => $this->organization,
            'sender' => $this->sender,
        ];
    }
}
