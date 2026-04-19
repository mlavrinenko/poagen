<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

use DateTimeImmutable;
use JsonSerializable;

final readonly class SimpleCheckSuite implements JsonSerializable
{
    /**
     * Paogen marshal/unmarshal contract — phpName => [wireKey, shape]. See ADR-007.
     * @var array<string, array{0: string, 1: null|class-string|array{0: string, 1: null|class-string}|array{0: string, 1: list<class-string>, 2: ?string}}>
     */
    public const array PROPERTY_MAP = [
        'after' => ['after', null],
        'app' => ['app', \Acme\GitHub\Generated\Model\Integration::class],
        'before' => ['before', null],
        'conclusion' => ['conclusion', null],
        'created_at' => ['created_at', ['datetime', null]],
        'head_branch' => ['head_branch', null],
        'head_sha' => ['head_sha', null],
        'id' => ['id', null],
        'node_id' => ['node_id', null],
        'pull_requests' => ['pull_requests', ['list', \Acme\GitHub\Generated\Model\PullRequestMinimal::class]],
        'repository' => ['repository', \Acme\GitHub\Generated\Model\MinimalRepository::class],
        'status' => ['status', null],
        'updated_at' => ['updated_at', ['datetime', null]],
        'url' => ['url', null],
    ];

    /**
     * @param ?list<\Acme\GitHub\Generated\Model\PullRequestMinimal> $pull_requests
     */
    public function __construct(
        public ?string $after = null,
        public ?Integration $app = null,
        public ?string $before = null,
        public ?string $conclusion = null,
        public ?DateTimeImmutable $created_at = null,
        public ?string $head_branch = null,
        public ?string $head_sha = null,
        public ?int $id = null,
        public ?string $node_id = null,
        public ?array $pull_requests = null,
        public ?MinimalRepository $repository = null,
        public ?string $status = null,
        public ?DateTimeImmutable $updated_at = null,
        public ?string $url = null,
    ) {
    }

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'after' => $this->after,
            'app' => $this->app,
            'before' => $this->before,
            'conclusion' => $this->conclusion,
            'created_at' => $this->created_at?->format(\DateTimeInterface::RFC3339),
            'head_branch' => $this->head_branch,
            'head_sha' => $this->head_sha,
            'id' => $this->id,
            'node_id' => $this->node_id,
            'pull_requests' => $this->pull_requests,
            'repository' => $this->repository,
            'status' => $this->status,
            'updated_at' => $this->updated_at?->format(\DateTimeInterface::RFC3339),
            'url' => $this->url,
        ];
    }
}
