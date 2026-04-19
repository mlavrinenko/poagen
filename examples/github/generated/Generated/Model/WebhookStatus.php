<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

use JsonSerializable;

final readonly class WebhookStatus implements JsonSerializable
{
    /**
     * Paogen marshal/unmarshal contract — phpName => [wireKey, shape]. See ADR-007.
     * @var array<string, array{0: string, 1: null|class-string|array{0: string, 1: null|class-string}|array{0: string, 1: list<class-string>, 2: ?string}}>
     */
    public const array PROPERTY_MAP = [
        'branches' => ['branches', ['list', null]],
        'commit' => ['commit', \Acme\GitHub\Generated\Model\WebhookStatusCommit::class],
        'context' => ['context', null],
        'created_at' => ['created_at', null],
        'description' => ['description', null],
        'id' => ['id', null],
        'name' => ['name', null],
        'repository' => ['repository', \Acme\GitHub\Generated\Model\RepositoryWebhooks::class],
        'sender' => ['sender', \Acme\GitHub\Generated\Model\SimpleUser::class],
        'sha' => ['sha', null],
        'state' => ['state', null],
        'target_url' => ['target_url', null],
        'updated_at' => ['updated_at', null],
        'avatar_url' => ['avatar_url', null],
        'enterprise' => ['enterprise', \Acme\GitHub\Generated\Model\EnterpriseWebhooks::class],
        'installation' => ['installation', \Acme\GitHub\Generated\Model\SimpleInstallation::class],
        'organization' => ['organization', \Acme\GitHub\Generated\Model\OrganizationSimpleWebhooks::class],
    ];

    /**
     * @param list<array<string, mixed>> $branches
     */
    public function __construct(
        public array $branches,
        public WebhookStatusCommit $commit,
        public string $context,
        public string $created_at,
        public ?string $description = null,
        public int $id,
        public string $name,
        public RepositoryWebhooks $repository,
        public SimpleUser $sender,
        public string $sha,
        public string $state,
        public ?string $target_url = null,
        public string $updated_at,
        public ?string $avatar_url = null,
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
            'branches' => $this->branches,
            'commit' => $this->commit,
            'context' => $this->context,
            'created_at' => $this->created_at,
            'description' => $this->description,
            'id' => $this->id,
            'name' => $this->name,
            'repository' => $this->repository,
            'sender' => $this->sender,
            'sha' => $this->sha,
            'state' => $this->state,
            'target_url' => $this->target_url,
            'updated_at' => $this->updated_at,
            'avatar_url' => $this->avatar_url,
            'enterprise' => $this->enterprise,
            'installation' => $this->installation,
            'organization' => $this->organization,
        ];
    }
}
