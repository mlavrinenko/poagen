<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

use DateTimeImmutable;
use JsonSerializable;

final readonly class WebhookSecretScanningScanCompleted implements JsonSerializable
{
    /**
     * Paogen marshal/unmarshal contract — phpName => [wireKey, shape]. See ADR-007.
     * @var array<string, array{0: string, 1: null|class-string|array{0: string, 1: null|class-string}|array{0: string, 1: list<class-string>, 2: ?string}}>
     */
    public const array PROPERTY_MAP = [
        'action' => ['action', null],
        'completed_at' => ['completed_at', ['datetime', null]],
        'source' => ['source', null],
        'started_at' => ['started_at', ['datetime', null]],
        'type' => ['type', null],
        'custom_pattern_name' => ['custom_pattern_name', null],
        'custom_pattern_scope' => ['custom_pattern_scope', null],
        'enterprise' => ['enterprise', \Acme\GitHub\Generated\Model\EnterpriseWebhooks::class],
        'installation' => ['installation', \Acme\GitHub\Generated\Model\SimpleInstallation::class],
        'organization' => ['organization', \Acme\GitHub\Generated\Model\OrganizationSimpleWebhooks::class],
        'repository' => ['repository', \Acme\GitHub\Generated\Model\RepositoryWebhooks::class],
        'secret_types' => ['secret_types', ['list', null]],
        'sender' => ['sender', \Acme\GitHub\Generated\Model\SimpleUser::class],
    ];

    /**
     * @param ?list<string> $secret_types
     */
    public function __construct(
        public string $action,
        public DateTimeImmutable $completed_at,
        public string $source,
        public DateTimeImmutable $started_at,
        public string $type,
        public ?string $custom_pattern_name = null,
        public ?string $custom_pattern_scope = null,
        public ?EnterpriseWebhooks $enterprise = null,
        public ?SimpleInstallation $installation = null,
        public ?OrganizationSimpleWebhooks $organization = null,
        public ?RepositoryWebhooks $repository = null,
        public ?array $secret_types = null,
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
            'completed_at' => $this->completed_at->format(\DateTimeInterface::RFC3339),
            'source' => $this->source,
            'started_at' => $this->started_at->format(\DateTimeInterface::RFC3339),
            'type' => $this->type,
            'custom_pattern_name' => $this->custom_pattern_name,
            'custom_pattern_scope' => $this->custom_pattern_scope,
            'enterprise' => $this->enterprise,
            'installation' => $this->installation,
            'organization' => $this->organization,
            'repository' => $this->repository,
            'secret_types' => $this->secret_types,
            'sender' => $this->sender,
        ];
    }
}
