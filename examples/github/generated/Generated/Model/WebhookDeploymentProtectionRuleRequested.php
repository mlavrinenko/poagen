<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

use JsonSerializable;

final readonly class WebhookDeploymentProtectionRuleRequested implements JsonSerializable
{
    /**
     * Paogen marshal/unmarshal contract — phpName => [wireKey, shape]. See ADR-007.
     * @var array<string, array{0: string, 1: null|class-string|array{0: string, 1: null|class-string}|array{0: string, 1: list<class-string>, 2: ?string}}>
     */
    public const array PROPERTY_MAP = [
        'action' => ['action', null],
        'deployment' => ['deployment', \Acme\GitHub\Generated\Model\NullableDeployment::class],
        'deployment_callback_url' => ['deployment_callback_url', null],
        'environment' => ['environment', null],
        'event' => ['event', null],
        'installation' => ['installation', \Acme\GitHub\Generated\Model\SimpleInstallation::class],
        'organization' => ['organization', \Acme\GitHub\Generated\Model\OrganizationSimpleWebhooks::class],
        'pull_requests' => ['pull_requests', ['list', \Acme\GitHub\Generated\Model\PullRequest::class]],
        'ref' => ['ref', null],
        'repository' => ['repository', \Acme\GitHub\Generated\Model\RepositoryWebhooks::class],
        'sender' => ['sender', \Acme\GitHub\Generated\Model\SimpleUser::class],
        'sha' => ['sha', null],
    ];

    /**
     * @param ?list<\Acme\GitHub\Generated\Model\PullRequest> $pull_requests
     */
    public function __construct(
        public ?string $action = null,
        public ?NullableDeployment $deployment = null,
        public ?string $deployment_callback_url = null,
        public ?string $environment = null,
        public ?string $event = null,
        public ?SimpleInstallation $installation = null,
        public ?OrganizationSimpleWebhooks $organization = null,
        public ?array $pull_requests = null,
        public ?string $ref = null,
        public ?RepositoryWebhooks $repository = null,
        public ?SimpleUser $sender = null,
        public ?string $sha = null,
    ) {
    }

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'action' => $this->action,
            'deployment' => $this->deployment,
            'deployment_callback_url' => $this->deployment_callback_url,
            'environment' => $this->environment,
            'event' => $this->event,
            'installation' => $this->installation,
            'organization' => $this->organization,
            'pull_requests' => $this->pull_requests,
            'ref' => $this->ref,
            'repository' => $this->repository,
            'sender' => $this->sender,
            'sha' => $this->sha,
        ];
    }
}
