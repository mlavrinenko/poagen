<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

use DateTimeImmutable;
use JsonSerializable;

final readonly class Deployment implements JsonSerializable
{
    /**
     * Paogen marshal/unmarshal contract — phpName => [wireKey, shape]. See ADR-007.
     * @var array<string, array{0: string, 1: null|class-string|array{0: string, 1: null|class-string}|array{0: string, 1: list<class-string>, 2: ?string}}>
     */
    public const array PROPERTY_MAP = [
        'created_at' => ['created_at', ['datetime', null]],
        'creator' => ['creator', \Acme\GitHub\Generated\Model\NullableSimpleUser::class],
        'description' => ['description', null],
        'environment' => ['environment', null],
        'id' => ['id', null],
        'node_id' => ['node_id', null],
        'payload' => ['payload', null],
        'ref' => ['ref', null],
        'repository_url' => ['repository_url', null],
        'sha' => ['sha', null],
        'statuses_url' => ['statuses_url', null],
        'task' => ['task', null],
        'updated_at' => ['updated_at', ['datetime', null]],
        'url' => ['url', null],
        'original_environment' => ['original_environment', null],
        'performed_via_github_app' => ['performed_via_github_app', \Acme\GitHub\Generated\Model\NullableIntegration::class],
        'production_environment' => ['production_environment', null],
        'transient_environment' => ['transient_environment', null],
    ];

    /**
     * @param mixed $payload
     */
    public function __construct(
        public DateTimeImmutable $created_at,
        public NullableSimpleUser $creator,
        public ?string $description = null,
        public string $environment,
        public int $id,
        public string $node_id,
        public $payload,
        public string $ref,
        public string $repository_url,
        public string $sha,
        public string $statuses_url,
        public string $task,
        public DateTimeImmutable $updated_at,
        public string $url,
        public ?string $original_environment = null,
        public ?NullableIntegration $performed_via_github_app = null,
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
            'created_at' => $this->created_at->format(\DateTimeInterface::RFC3339),
            'creator' => $this->creator,
            'description' => $this->description,
            'environment' => $this->environment,
            'id' => $this->id,
            'node_id' => $this->node_id,
            'payload' => $this->payload,
            'ref' => $this->ref,
            'repository_url' => $this->repository_url,
            'sha' => $this->sha,
            'statuses_url' => $this->statuses_url,
            'task' => $this->task,
            'updated_at' => $this->updated_at->format(\DateTimeInterface::RFC3339),
            'url' => $this->url,
            'original_environment' => $this->original_environment,
            'performed_via_github_app' => $this->performed_via_github_app,
            'production_environment' => $this->production_environment,
            'transient_environment' => $this->transient_environment,
        ];
    }
}
