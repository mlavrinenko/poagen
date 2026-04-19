<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

use Acme\GitHub\Generated\Enum\CodeScanningVariantAnalysisStatus;
use JsonSerializable;

final readonly class CodeScanningVariantAnalysisRepoTask implements JsonSerializable
{
    /**
     * Paogen marshal/unmarshal contract — phpName => [wireKey, shape]. See ADR-007.
     * @var array<string, array{0: string, 1: null|class-string|array{0: string, 1: null|class-string}|array{0: string, 1: list<class-string>, 2: ?string}}>
     */
    public const array PROPERTY_MAP = [
        'analysis_status' => [
            'analysis_status',
            ['enum', \Acme\GitHub\Generated\Enum\CodeScanningVariantAnalysisStatus::class],
        ],
        'repository' => ['repository', \Acme\GitHub\Generated\Model\SimpleRepository::class],
        'artifact_size_in_bytes' => ['artifact_size_in_bytes', null],
        'artifact_url' => ['artifact_url', null],
        'database_commit_sha' => ['database_commit_sha', null],
        'failure_message' => ['failure_message', null],
        'result_count' => ['result_count', null],
        'source_location_prefix' => ['source_location_prefix', null],
    ];

    public function __construct(
        public CodeScanningVariantAnalysisStatus $analysis_status,
        public SimpleRepository $repository,
        public ?int $artifact_size_in_bytes = null,
        public ?string $artifact_url = null,
        public ?string $database_commit_sha = null,
        public ?string $failure_message = null,
        public ?int $result_count = null,
        public ?string $source_location_prefix = null,
    ) {
    }

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'analysis_status' => $this->analysis_status,
            'repository' => $this->repository,
            'artifact_size_in_bytes' => $this->artifact_size_in_bytes,
            'artifact_url' => $this->artifact_url,
            'database_commit_sha' => $this->database_commit_sha,
            'failure_message' => $this->failure_message,
            'result_count' => $this->result_count,
            'source_location_prefix' => $this->source_location_prefix,
        ];
    }
}
