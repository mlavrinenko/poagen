<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

use JsonSerializable;

final readonly class CodeScanningVariantAnalysisSkippedRepoGroup implements JsonSerializable
{
    /**
     * Paogen marshal/unmarshal contract — phpName => [wireKey, shape]. See ADR-007.
     * @var array<string, array{0: string, 1: null|class-string|array{0: string, 1: null|class-string}|array{0: string, 1: list<class-string>, 2: ?string}}>
     */
    public const array PROPERTY_MAP = [
        'repositories' => [
            'repositories',
            ['list', \Acme\GitHub\Generated\Model\CodeScanningVariantAnalysisRepository::class],
        ],
        'repository_count' => ['repository_count', null],
    ];

    /**
     * @param list<\Acme\GitHub\Generated\Model\CodeScanningVariantAnalysisRepository> $repositories
     */
    public function __construct(
        public array $repositories,
        public int $repository_count,
    ) {
    }

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'repositories' => $this->repositories,
            'repository_count' => $this->repository_count,
        ];
    }
}
