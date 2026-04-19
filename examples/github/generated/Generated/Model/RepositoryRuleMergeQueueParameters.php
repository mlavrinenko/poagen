<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

use JsonSerializable;

final readonly class RepositoryRuleMergeQueueParameters implements JsonSerializable
{
    /**
     * Paogen marshal/unmarshal contract — phpName => [wireKey, shape]. See ADR-007.
     * @var array<string, array{0: string, 1: null|class-string|array{0: string, 1: null|class-string}|array{0: string, 1: list<class-string>, 2: ?string}}>
     */
    public const array PROPERTY_MAP = [
        'check_response_timeout_minutes' => ['check_response_timeout_minutes', null],
        'grouping_strategy' => ['grouping_strategy', null],
        'max_entries_to_build' => ['max_entries_to_build', null],
        'max_entries_to_merge' => ['max_entries_to_merge', null],
        'merge_method' => ['merge_method', null],
        'min_entries_to_merge' => ['min_entries_to_merge', null],
        'min_entries_to_merge_wait_minutes' => ['min_entries_to_merge_wait_minutes', null],
    ];

    public function __construct(
        public int $check_response_timeout_minutes,
        public string $grouping_strategy,
        public int $max_entries_to_build,
        public int $max_entries_to_merge,
        public string $merge_method,
        public int $min_entries_to_merge,
        public int $min_entries_to_merge_wait_minutes,
    ) {
    }

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'check_response_timeout_minutes' => $this->check_response_timeout_minutes,
            'grouping_strategy' => $this->grouping_strategy,
            'max_entries_to_build' => $this->max_entries_to_build,
            'max_entries_to_merge' => $this->max_entries_to_merge,
            'merge_method' => $this->merge_method,
            'min_entries_to_merge' => $this->min_entries_to_merge,
            'min_entries_to_merge_wait_minutes' => $this->min_entries_to_merge_wait_minutes,
        ];
    }
}
