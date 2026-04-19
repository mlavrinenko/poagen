<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

use JsonSerializable;

final readonly class CodeScanningVariantAnalysisSkipped_repositoriesNot_found_repos implements JsonSerializable
{
    /**
     * Paogen marshal/unmarshal contract — phpName => [wireKey, shape]. See ADR-007.
     * @var array<string, array{0: string, 1: null|class-string|array{0: string, 1: null|class-string}|array{0: string, 1: list<class-string>, 2: ?string}}>
     */
    public const array PROPERTY_MAP = [
        'repository_count' => ['repository_count', null],
        'repository_full_names' => ['repository_full_names', ['list', null]],
    ];

    /**
     * @param list<string> $repository_full_names
     */
    public function __construct(
        public int $repository_count,
        public array $repository_full_names,
    ) {
    }

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'repository_count' => $this->repository_count,
            'repository_full_names' => $this->repository_full_names,
        ];
    }
}
