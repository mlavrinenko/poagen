<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

use JsonSerializable;

final readonly class CombinedCommitStatus implements JsonSerializable
{
    /**
     * Paogen marshal/unmarshal contract — phpName => [wireKey, shape]. See ADR-007.
     * @var array<string, array{0: string, 1: null|class-string|array{0: string, 1: null|class-string}|array{0: string, 1: list<class-string>, 2: ?string}}>
     */
    public const array PROPERTY_MAP = [
        'commit_url' => ['commit_url', null],
        'repository' => ['repository', \Acme\GitHub\Generated\Model\MinimalRepository::class],
        'sha' => ['sha', null],
        'state' => ['state', null],
        'statuses' => ['statuses', ['list', \Acme\GitHub\Generated\Model\SimpleCommitStatus::class]],
        'total_count' => ['total_count', null],
        'url' => ['url', null],
    ];

    /**
     * @param list<\Acme\GitHub\Generated\Model\SimpleCommitStatus> $statuses
     */
    public function __construct(
        public string $commit_url,
        public MinimalRepository $repository,
        public string $sha,
        public string $state,
        public array $statuses,
        public int $total_count,
        public string $url,
    ) {
    }

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'commit_url' => $this->commit_url,
            'repository' => $this->repository,
            'sha' => $this->sha,
            'state' => $this->state,
            'statuses' => $this->statuses,
            'total_count' => $this->total_count,
            'url' => $this->url,
        ];
    }
}
