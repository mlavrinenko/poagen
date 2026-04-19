<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

use Acme\GitHub\Generated\Enum\CodeScanningVariantAnalysisLanguage;
use DateTimeImmutable;
use JsonSerializable;

final readonly class CodeScanningVariantAnalysis implements JsonSerializable
{
    /**
     * Paogen marshal/unmarshal contract — phpName => [wireKey, shape]. See ADR-007.
     * @var array<string, array{0: string, 1: null|class-string|array{0: string, 1: null|class-string}|array{0: string, 1: list<class-string>, 2: ?string}}>
     */
    public const array PROPERTY_MAP = [
        'actor' => ['actor', \Acme\GitHub\Generated\Model\SimpleUser::class],
        'controller_repo' => ['controller_repo', \Acme\GitHub\Generated\Model\SimpleRepository::class],
        'id' => ['id', null],
        'query_language' => [
            'query_language',
            ['enum', \Acme\GitHub\Generated\Enum\CodeScanningVariantAnalysisLanguage::class],
        ],
        'query_pack_url' => ['query_pack_url', null],
        'status' => ['status', null],
        'actions_workflow_run_id' => ['actions_workflow_run_id', null],
        'completed_at' => ['completed_at', ['datetime', null]],
        'created_at' => ['created_at', ['datetime', null]],
        'failure_reason' => ['failure_reason', null],
        'scanned_repositories' => ['scanned_repositories', ['list', null]],
        'skipped_repositories' => [
            'skipped_repositories',
            \Acme\GitHub\Generated\Model\CodeScanningVariantAnalysisSkipped_repositories::class,
        ],
        'updated_at' => ['updated_at', ['datetime', null]],
    ];

    /**
     * @param ?list<array<string, mixed>> $scanned_repositories
     */
    public function __construct(
        public SimpleUser $actor,
        public SimpleRepository $controller_repo,
        public int $id,
        public CodeScanningVariantAnalysisLanguage $query_language,
        public string $query_pack_url,
        public string $status,
        public ?int $actions_workflow_run_id = null,
        public ?DateTimeImmutable $completed_at = null,
        public ?DateTimeImmutable $created_at = null,
        public ?string $failure_reason = null,
        public ?array $scanned_repositories = null,
        public ?CodeScanningVariantAnalysisSkipped_repositories $skipped_repositories = null,
        public ?DateTimeImmutable $updated_at = null,
    ) {
    }

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'actor' => $this->actor,
            'controller_repo' => $this->controller_repo,
            'id' => $this->id,
            'query_language' => $this->query_language,
            'query_pack_url' => $this->query_pack_url,
            'status' => $this->status,
            'actions_workflow_run_id' => $this->actions_workflow_run_id,
            'completed_at' => $this->completed_at?->format(\DateTimeInterface::RFC3339),
            'created_at' => $this->created_at?->format(\DateTimeInterface::RFC3339),
            'failure_reason' => $this->failure_reason,
            'scanned_repositories' => $this->scanned_repositories,
            'skipped_repositories' => $this->skipped_repositories,
            'updated_at' => $this->updated_at?->format(\DateTimeInterface::RFC3339),
        ];
    }
}
