<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

use JsonSerializable;

final readonly class CodeScanningVariantAnalysisSkipped_repositories implements JsonSerializable
{
    /**
     * Paogen marshal/unmarshal contract — phpName => [wireKey, shape]. See ADR-007.
     * @var array<string, array{0: string, 1: null|class-string|array{0: string, 1: null|class-string}|array{0: string, 1: list<class-string>, 2: ?string}}>
     */
    public const array PROPERTY_MAP = [
        'access_mismatch_repos' => [
            'access_mismatch_repos',
            \Acme\GitHub\Generated\Model\CodeScanningVariantAnalysisSkippedRepoGroup::class,
        ],
        'no_codeql_db_repos' => [
            'no_codeql_db_repos',
            \Acme\GitHub\Generated\Model\CodeScanningVariantAnalysisSkippedRepoGroup::class,
        ],
        'not_found_repos' => [
            'not_found_repos',
            \Acme\GitHub\Generated\Model\CodeScanningVariantAnalysisSkipped_repositoriesNot_found_repos::class,
        ],
        'over_limit_repos' => [
            'over_limit_repos',
            \Acme\GitHub\Generated\Model\CodeScanningVariantAnalysisSkippedRepoGroup::class,
        ],
    ];

    public function __construct(
        public CodeScanningVariantAnalysisSkippedRepoGroup $access_mismatch_repos,
        public CodeScanningVariantAnalysisSkippedRepoGroup $no_codeql_db_repos,
        public CodeScanningVariantAnalysisSkipped_repositoriesNot_found_repos $not_found_repos,
        public CodeScanningVariantAnalysisSkippedRepoGroup $over_limit_repos,
    ) {
    }

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'access_mismatch_repos' => $this->access_mismatch_repos,
            'no_codeql_db_repos' => $this->no_codeql_db_repos,
            'not_found_repos' => $this->not_found_repos,
            'over_limit_repos' => $this->over_limit_repos,
        ];
    }
}
