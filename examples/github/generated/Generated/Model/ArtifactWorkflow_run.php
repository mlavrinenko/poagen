<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

use JsonSerializable;

final readonly class ArtifactWorkflow_run implements JsonSerializable
{
    /**
     * Paogen marshal/unmarshal contract — phpName => [wireKey, shape]. See ADR-007.
     * @var array<string, array{0: string, 1: null|class-string|array{0: string, 1: null|class-string}|array{0: string, 1: list<class-string>, 2: ?string}}>
     */
    public const array PROPERTY_MAP = [
        'head_branch' => ['head_branch', null],
        'head_repository_id' => ['head_repository_id', null],
        'head_sha' => ['head_sha', null],
        'id' => ['id', null],
        'repository_id' => ['repository_id', null],
    ];

    public function __construct(
        public ?string $head_branch = null,
        public ?int $head_repository_id = null,
        public ?string $head_sha = null,
        public ?int $id = null,
        public ?int $repository_id = null,
    ) {
    }

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'head_branch' => $this->head_branch,
            'head_repository_id' => $this->head_repository_id,
            'head_sha' => $this->head_sha,
            'id' => $this->id,
            'repository_id' => $this->repository_id,
        ];
    }
}
