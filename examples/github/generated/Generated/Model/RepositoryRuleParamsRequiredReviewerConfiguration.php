<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

use JsonSerializable;

final readonly class RepositoryRuleParamsRequiredReviewerConfiguration implements JsonSerializable
{
    /**
     * Paogen marshal/unmarshal contract — phpName => [wireKey, shape]. See ADR-007.
     * @var array<string, array{0: string, 1: null|class-string|array{0: string, 1: null|class-string}|array{0: string, 1: list<class-string>, 2: ?string}}>
     */
    public const array PROPERTY_MAP = [
        'file_patterns' => ['file_patterns', ['list', null]],
        'minimum_approvals' => ['minimum_approvals', null],
        'reviewer' => ['reviewer', \Acme\GitHub\Generated\Model\RepositoryRuleParamsReviewer::class],
    ];

    /**
     * @param list<string> $file_patterns
     */
    public function __construct(
        public array $file_patterns,
        public int $minimum_approvals,
        public RepositoryRuleParamsReviewer $reviewer,
    ) {
    }

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'file_patterns' => $this->file_patterns,
            'minimum_approvals' => $this->minimum_approvals,
            'reviewer' => $this->reviewer,
        ];
    }
}
