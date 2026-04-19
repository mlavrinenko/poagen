<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

use JsonSerializable;

final readonly class WebhookProjectCardConverted implements JsonSerializable
{
    /**
     * Paogen marshal/unmarshal contract — phpName => [wireKey, shape]. See ADR-007.
     * @var array<string, array{0: string, 1: null|class-string|array{0: string, 1: null|class-string}|array{0: string, 1: list<class-string>, 2: ?string}}>
     */
    public const array PROPERTY_MAP = [
        'action' => ['action', null],
        'changes' => ['changes', \Acme\GitHub\Generated\Model\WebhookProjectCardConvertedChanges::class],
        'project_card' => ['project_card', \Acme\GitHub\Generated\Model\WebhooksProjectCard::class],
        'sender' => ['sender', \Acme\GitHub\Generated\Model\SimpleUser::class],
        'enterprise' => ['enterprise', \Acme\GitHub\Generated\Model\EnterpriseWebhooks::class],
        'installation' => ['installation', \Acme\GitHub\Generated\Model\SimpleInstallation::class],
        'organization' => ['organization', \Acme\GitHub\Generated\Model\OrganizationSimpleWebhooks::class],
        'repository' => ['repository', \Acme\GitHub\Generated\Model\RepositoryWebhooks::class],
    ];

    public function __construct(
        public string $action,
        public WebhookProjectCardConvertedChanges $changes,
        public WebhooksProjectCard $project_card,
        public SimpleUser $sender,
        public ?EnterpriseWebhooks $enterprise = null,
        public ?SimpleInstallation $installation = null,
        public ?OrganizationSimpleWebhooks $organization = null,
        public ?RepositoryWebhooks $repository = null,
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
            'project_card' => $this->project_card,
            'sender' => $this->sender,
            'enterprise' => $this->enterprise,
            'installation' => $this->installation,
            'organization' => $this->organization,
            'repository' => $this->repository,
        ];
    }
}
