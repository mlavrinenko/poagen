<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

use DateTimeImmutable;
use JsonSerializable;

final readonly class CheckSuite implements JsonSerializable
{
    /**
     * Paogen marshal/unmarshal contract — phpName => [wireKey, shape]. See ADR-007.
     * @var array<string, array{0: string, 1: null|class-string|array{0: string, 1: null|class-string}|array{0: string, 1: list<class-string>, 2: ?string}}>
     */
    public const array PROPERTY_MAP = [
        'after' => ['after', null],
        'app' => ['app', \Acme\GitHub\Generated\Model\NullableIntegration::class],
        'before' => ['before', null],
        'check_runs_url' => ['check_runs_url', null],
        'conclusion' => ['conclusion', null],
        'created_at' => ['created_at', ['datetime', null]],
        'head_branch' => ['head_branch', null],
        'head_commit' => ['head_commit', \Acme\GitHub\Generated\Model\SimpleCommit::class],
        'head_sha' => ['head_sha', null],
        'id' => ['id', null],
        'latest_check_runs_count' => ['latest_check_runs_count', null],
        'node_id' => ['node_id', null],
        'pull_requests' => ['pull_requests', ['list', \Acme\GitHub\Generated\Model\PullRequestMinimal::class]],
        'repository' => ['repository', \Acme\GitHub\Generated\Model\MinimalRepository::class],
        'status' => ['status', null],
        'updated_at' => ['updated_at', ['datetime', null]],
        'url' => ['url', null],
        'rerequestable' => ['rerequestable', null],
        'runs_rerequestable' => ['runs_rerequestable', null],
    ];

    /**
     * @param ?list<\Acme\GitHub\Generated\Model\PullRequestMinimal> $pull_requests
     */
    public function __construct(
        public ?string $after = null,
        public NullableIntegration $app,
        public ?string $before = null,
        public string $check_runs_url,
        public ?string $conclusion = null,
        public ?DateTimeImmutable $created_at = null,
        public ?string $head_branch = null,
        public SimpleCommit $head_commit,
        public string $head_sha,
        public int $id,
        public int $latest_check_runs_count,
        public string $node_id,
        public ?array $pull_requests = null,
        public MinimalRepository $repository,
        public ?string $status = null,
        public ?DateTimeImmutable $updated_at = null,
        public ?string $url = null,
        public ?bool $rerequestable = null,
        public ?bool $runs_rerequestable = null,
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
            'check_runs_url' => $this->check_runs_url,
            'conclusion' => $this->conclusion,
            'created_at' => $this->created_at?->format(\DateTimeInterface::RFC3339),
            'head_branch' => $this->head_branch,
            'head_commit' => $this->head_commit,
            'head_sha' => $this->head_sha,
            'id' => $this->id,
            'latest_check_runs_count' => $this->latest_check_runs_count,
            'node_id' => $this->node_id,
            'pull_requests' => $this->pull_requests,
            'repository' => $this->repository,
            'status' => $this->status,
            'updated_at' => $this->updated_at?->format(\DateTimeInterface::RFC3339),
            'url' => $this->url,
            'rerequestable' => $this->rerequestable,
            'runs_rerequestable' => $this->runs_rerequestable,
        ];
    }
}
