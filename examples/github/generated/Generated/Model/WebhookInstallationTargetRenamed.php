<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

use JsonSerializable;

final readonly class WebhookInstallationTargetRenamed implements JsonSerializable
{
    /**
     * Paogen marshal/unmarshal contract — phpName => [wireKey, shape]. See ADR-007.
     * @var array<string, array{0: string, 1: null|class-string|array{0: string, 1: null|class-string}|array{0: string, 1: list<class-string>, 2: ?string}}>
     */
    public const array PROPERTY_MAP = [
        'account' => ['account', \Acme\GitHub\Generated\Model\WebhookInstallationTargetRenamedAccount::class],
        'action' => ['action', null],
        'changes' => ['changes', \Acme\GitHub\Generated\Model\WebhookInstallationTargetRenamedChanges::class],
        'installation' => ['installation', \Acme\GitHub\Generated\Model\SimpleInstallation::class],
        'target_type' => ['target_type', null],
        'enterprise' => ['enterprise', \Acme\GitHub\Generated\Model\EnterpriseWebhooks::class],
        'organization' => ['organization', \Acme\GitHub\Generated\Model\OrganizationSimpleWebhooks::class],
        'repository' => ['repository', \Acme\GitHub\Generated\Model\RepositoryWebhooks::class],
        'sender' => ['sender', \Acme\GitHub\Generated\Model\SimpleUser::class],
    ];

    public function __construct(
        public WebhookInstallationTargetRenamedAccount $account,
        public string $action,
        public WebhookInstallationTargetRenamedChanges $changes,
        public SimpleInstallation $installation,
        public string $target_type,
        public ?EnterpriseWebhooks $enterprise = null,
        public ?OrganizationSimpleWebhooks $organization = null,
        public ?RepositoryWebhooks $repository = null,
        public ?SimpleUser $sender = null,
    ) {
    }

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'account' => $this->account,
            'action' => $this->action,
            'changes' => $this->changes,
            'installation' => $this->installation,
            'target_type' => $this->target_type,
            'enterprise' => $this->enterprise,
            'organization' => $this->organization,
            'repository' => $this->repository,
            'sender' => $this->sender,
        ];
    }
}
