<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

use JsonSerializable;

final readonly class WebhookDeploymentCreatedDeployment implements JsonSerializable
{
    /**
     * Paogen marshal/unmarshal contract — phpName => [wireKey, shape]. See ADR-007.
     * @var array<string, array{0: string, 1: null|class-string|array{0: string, 1: null|class-string}|array{0: string, 1: list<class-string>, 2: ?string}}>
     */
    public const array PROPERTY_MAP = [
        'created_at' => ['created_at', null],
        'creator' => ['creator', \Acme\GitHub\Generated\Model\WebhookDeploymentCreatedDeploymentCreator::class],
        'description' => ['description', null],
        'environment' => ['environment', null],
        'id' => ['id', null],
        'node_id' => ['node_id', null],
        'original_environment' => ['original_environment', null],
        'payload' => ['payload', null],
        'ref' => ['ref', null],
        'repository_url' => ['repository_url', null],
        'sha' => ['sha', null],
        'statuses_url' => ['statuses_url', null],
        'task' => ['task', null],
        'updated_at' => ['updated_at', null],
        'url' => ['url', null],
        'performed_via_github_app' => [
            'performed_via_github_app',
            \Acme\GitHub\Generated\Model\WebhookDeploymentCreatedDeploymentPerformed_via_github_app::class,
        ],
        'production_environment' => ['production_environment', null],
        'transient_environment' => ['transient_environment', null],
    ];

    /**
     * @param mixed $payload
     */
    public function __construct(
        public string $created_at,
        public WebhookDeploymentCreatedDeploymentCreator $creator,
        public ?string $description = null,
        public string $environment,
        public int $id,
        public string $node_id,
        public string $original_environment,
        public $payload,
        public string $ref,
        public string $repository_url,
        public string $sha,
        public string $statuses_url,
        public string $task,
        public string $updated_at,
        public string $url,
        public ?WebhookDeploymentCreatedDeploymentPerformed_via_github_app $performed_via_github_app = null,
        public ?bool $production_environment = null,
        public ?bool $transient_environment = null,
    ) {
    }

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'created_at' => $this->created_at,
            'creator' => $this->creator,
            'description' => $this->description,
            'environment' => $this->environment,
            'id' => $this->id,
            'node_id' => $this->node_id,
            'original_environment' => $this->original_environment,
            'payload' => $this->payload,
            'ref' => $this->ref,
            'repository_url' => $this->repository_url,
            'sha' => $this->sha,
            'statuses_url' => $this->statuses_url,
            'task' => $this->task,
            'updated_at' => $this->updated_at,
            'url' => $this->url,
            'performed_via_github_app' => $this->performed_via_github_app,
            'production_environment' => $this->production_environment,
            'transient_environment' => $this->transient_environment,
        ];
    }
}
