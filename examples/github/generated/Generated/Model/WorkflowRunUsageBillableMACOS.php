<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

use JsonSerializable;

final readonly class WorkflowRunUsageBillableMACOS implements JsonSerializable
{
    /**
     * Paogen marshal/unmarshal contract — phpName => [wireKey, shape]. See ADR-007.
     * @var array<string, array{0: string, 1: null|class-string|array{0: string, 1: null|class-string}|array{0: string, 1: list<class-string>, 2: ?string}}>
     */
    public const array PROPERTY_MAP = [
        'jobs' => ['jobs', null],
        'total_ms' => ['total_ms', null],
        'job_runs' => ['job_runs', ['list', null]],
    ];

    /**
     * @param ?list<array<string, mixed>> $job_runs
     */
    public function __construct(
        public int $jobs,
        public int $total_ms,
        public ?array $job_runs = null,
    ) {
    }

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'jobs' => $this->jobs,
            'total_ms' => $this->total_ms,
            'job_runs' => $this->job_runs,
        ];
    }
}
