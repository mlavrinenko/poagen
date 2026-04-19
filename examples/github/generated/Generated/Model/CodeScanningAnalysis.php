<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

use JsonSerializable;

final readonly class CodeScanningAnalysis implements JsonSerializable
{
    /**
     * Paogen marshal/unmarshal contract — phpName => [wireKey, shape]. See ADR-007.
     * @var array<string, array{0: string, 1: null|class-string|array{0: string, 1: null|class-string}|array{0: string, 1: list<class-string>, 2: ?string}}>
     */
    public const array PROPERTY_MAP = [
        'analysis_key' => ['analysis_key', \Acme\GitHub\Generated\Model\CodeScanningAnalysisAnalysisKey::class],
        'commit_sha' => ['commit_sha', \Acme\GitHub\Generated\Model\CodeScanningAnalysisCommitSha::class],
        'created_at' => ['created_at', \Acme\GitHub\Generated\Model\CodeScanningAnalysisCreatedAt::class],
        'deletable' => ['deletable', null],
        'environment' => ['environment', \Acme\GitHub\Generated\Model\CodeScanningAnalysisEnvironment::class],
        'error' => ['error', null],
        'id' => ['id', null],
        'ref' => ['ref', \Acme\GitHub\Generated\Model\CodeScanningRef::class],
        'results_count' => ['results_count', null],
        'rules_count' => ['rules_count', null],
        'sarif_id' => ['sarif_id', \Acme\GitHub\Generated\Model\CodeScanningAnalysisSarifId::class],
        'tool' => ['tool', \Acme\GitHub\Generated\Model\CodeScanningAnalysisTool::class],
        'url' => ['url', \Acme\GitHub\Generated\Model\CodeScanningAnalysisUrl::class],
        'warning' => ['warning', null],
        'category' => ['category', \Acme\GitHub\Generated\Model\CodeScanningAnalysisCategory::class],
    ];

    public function __construct(
        public CodeScanningAnalysisAnalysisKey $analysis_key,
        public CodeScanningAnalysisCommitSha $commit_sha,
        public CodeScanningAnalysisCreatedAt $created_at,
        public bool $deletable,
        public CodeScanningAnalysisEnvironment $environment,
        public string $error,
        public int $id,
        public CodeScanningRef $ref,
        public int $results_count,
        public int $rules_count,
        public CodeScanningAnalysisSarifId $sarif_id,
        public CodeScanningAnalysisTool $tool,
        public CodeScanningAnalysisUrl $url,
        public string $warning,
        public ?CodeScanningAnalysisCategory $category = null,
    ) {
    }

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'analysis_key' => $this->analysis_key,
            'commit_sha' => $this->commit_sha,
            'created_at' => $this->created_at,
            'deletable' => $this->deletable,
            'environment' => $this->environment,
            'error' => $this->error,
            'id' => $this->id,
            'ref' => $this->ref,
            'results_count' => $this->results_count,
            'rules_count' => $this->rules_count,
            'sarif_id' => $this->sarif_id,
            'tool' => $this->tool,
            'url' => $this->url,
            'warning' => $this->warning,
            'category' => $this->category,
        ];
    }
}
