<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

use JsonSerializable;

final readonly class WebhookDiscussionCommentEdited implements JsonSerializable
{
    /**
     * Paogen marshal/unmarshal contract — phpName => [wireKey, shape]. See ADR-007.
     * @var array<string, array{0: string, 1: null|class-string|array{0: string, 1: null|class-string}|array{0: string, 1: list<class-string>, 2: ?string}}>
     */
    public const array PROPERTY_MAP = [
        'action' => ['action', null],
        'changes' => ['changes', \Acme\GitHub\Generated\Model\WebhookDiscussionCommentEditedChanges::class],
        'comment' => ['comment', \Acme\GitHub\Generated\Model\WebhooksComment::class],
        'discussion' => ['discussion', \Acme\GitHub\Generated\Model\Discussion::class],
        'repository' => ['repository', \Acme\GitHub\Generated\Model\RepositoryWebhooks::class],
        'sender' => ['sender', \Acme\GitHub\Generated\Model\SimpleUser::class],
        'enterprise' => ['enterprise', \Acme\GitHub\Generated\Model\EnterpriseWebhooks::class],
        'installation' => ['installation', \Acme\GitHub\Generated\Model\SimpleInstallation::class],
        'organization' => ['organization', \Acme\GitHub\Generated\Model\OrganizationSimpleWebhooks::class],
    ];

    public function __construct(
        public string $action,
        public WebhookDiscussionCommentEditedChanges $changes,
        public WebhooksComment $comment,
        public Discussion $discussion,
        public RepositoryWebhooks $repository,
        public SimpleUser $sender,
        public ?EnterpriseWebhooks $enterprise = null,
        public ?SimpleInstallation $installation = null,
        public ?OrganizationSimpleWebhooks $organization = null,
    ) {
    }

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'action' => $this->action,
            'changes' => $this->changes,
            'comment' => $this->comment,
            'discussion' => $this->discussion,
            'repository' => $this->repository,
            'sender' => $this->sender,
            'enterprise' => $this->enterprise,
            'installation' => $this->installation,
            'organization' => $this->organization,
        ];
    }
}
