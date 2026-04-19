<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

use Acme\GitHub\Generated\Enum\WebhooksRepositorySelection;
use JsonSerializable;

final readonly class WebhookInstallationRepositoriesRemoved implements JsonSerializable
{
    /**
     * Paogen marshal/unmarshal contract — phpName => [wireKey, shape]. See ADR-007.
     * @var array<string, array{0: string, 1: null|class-string|array{0: string, 1: null|class-string}|array{0: string, 1: list<class-string>, 2: ?string}}>
     */
    public const array PROPERTY_MAP = [
        'action' => ['action', null],
        'installation' => ['installation', \Acme\GitHub\Generated\Model\Installation::class],
        'repositories_added' => ['repositories_added', \Acme\GitHub\Generated\Model\WebhooksRepositoriesAdded::class],
        'repositories_removed' => ['repositories_removed', ['list', null]],
        'repository_selection' => [
            'repository_selection',
            ['enum', \Acme\GitHub\Generated\Enum\WebhooksRepositorySelection::class],
        ],
        'requester' => ['requester', \Acme\GitHub\Generated\Model\WebhooksUser::class],
        'sender' => ['sender', \Acme\GitHub\Generated\Model\SimpleUser::class],
        'enterprise' => ['enterprise', \Acme\GitHub\Generated\Model\EnterpriseWebhooks::class],
        'organization' => ['organization', \Acme\GitHub\Generated\Model\OrganizationSimpleWebhooks::class],
        'repository' => ['repository', \Acme\GitHub\Generated\Model\RepositoryWebhooks::class],
    ];

    /**
     * @param list<array<string, mixed>> $repositories_removed
     */
    public function __construct(
        public string $action,
        public Installation $installation,
        public WebhooksRepositoriesAdded $repositories_added,
        public array $repositories_removed,
        public WebhooksRepositorySelection $repository_selection,
        public WebhooksUser $requester,
        public SimpleUser $sender,
        public ?EnterpriseWebhooks $enterprise = null,
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
            'installation' => $this->installation,
            'repositories_added' => $this->repositories_added,
            'repositories_removed' => $this->repositories_removed,
            'repository_selection' => $this->repository_selection,
            'requester' => $this->requester,
            'sender' => $this->sender,
            'enterprise' => $this->enterprise,
            'organization' => $this->organization,
            'repository' => $this->repository,
        ];
    }
}
