<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

use DateTimeImmutable;
use JsonSerializable;

final readonly class DeploymentStatus implements JsonSerializable
{
    /**
     * Paogen marshal/unmarshal contract — phpName => [wireKey, shape]. See ADR-007.
     * @var array<string, array{0: string, 1: null|class-string|array{0: string, 1: null|class-string}|array{0: string, 1: list<class-string>, 2: ?string}}>
     */
    public const array PROPERTY_MAP = [
        'created_at' => ['created_at', ['datetime', null]],
        'creator' => ['creator', \Acme\GitHub\Generated\Model\NullableSimpleUser::class],
        'deployment_url' => ['deployment_url', null],
        'description' => ['description', null],
        'id' => ['id', null],
        'node_id' => ['node_id', null],
        'repository_url' => ['repository_url', null],
        'state' => ['state', null],
        'target_url' => ['target_url', null],
        'updated_at' => ['updated_at', ['datetime', null]],
        'url' => ['url', null],
        'environment' => ['environment', null],
        'environment_url' => ['environment_url', null],
        'log_url' => ['log_url', null],
        'performed_via_github_app' => ['performed_via_github_app', \Acme\GitHub\Generated\Model\NullableIntegration::class],
    ];

    public function __construct(
        public DateTimeImmutable $created_at,
        public NullableSimpleUser $creator,
        public string $deployment_url,
        public string $description,
        public int $id,
        public string $node_id,
        public string $repository_url,
        public string $state,
        public string $target_url,
        public DateTimeImmutable $updated_at,
        public string $url,
        public ?string $environment = null,
        public ?string $environment_url = null,
        public ?string $log_url = null,
        public ?NullableIntegration $performed_via_github_app = null,
    ) {
    }

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'created_at' => $this->created_at->format(\DateTimeInterface::RFC3339),
            'creator' => $this->creator,
            'deployment_url' => $this->deployment_url,
            'description' => $this->description,
            'id' => $this->id,
            'node_id' => $this->node_id,
            'repository_url' => $this->repository_url,
            'state' => $this->state,
            'target_url' => $this->target_url,
            'updated_at' => $this->updated_at->format(\DateTimeInterface::RFC3339),
            'url' => $this->url,
            'environment' => $this->environment,
            'environment_url' => $this->environment_url,
            'log_url' => $this->log_url,
            'performed_via_github_app' => $this->performed_via_github_app,
        ];
    }
}
