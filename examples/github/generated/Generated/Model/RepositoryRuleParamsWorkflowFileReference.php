<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

use JsonSerializable;

final readonly class RepositoryRuleParamsWorkflowFileReference implements JsonSerializable
{
    /**
     * Paogen marshal/unmarshal contract — phpName => [wireKey, shape]. See ADR-007.
     * @var array<string, array{0: string, 1: null|class-string|array{0: string, 1: null|class-string}|array{0: string, 1: list<class-string>, 2: ?string}}>
     */
    public const array PROPERTY_MAP = [
        'path' => ['path', null],
        'repository_id' => ['repository_id', null],
        'ref' => ['ref', null],
        'sha' => ['sha', null],
    ];

    public function __construct(
        public string $path,
        public int $repository_id,
        public ?string $ref = null,
        public ?string $sha = null,
    ) {
    }

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'path' => $this->path,
            'repository_id' => $this->repository_id,
            'ref' => $this->ref,
            'sha' => $this->sha,
        ];
    }
}
