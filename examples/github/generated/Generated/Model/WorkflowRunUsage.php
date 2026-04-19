<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

use JsonSerializable;

final readonly class WorkflowRunUsage implements JsonSerializable
{
    /**
     * Paogen marshal/unmarshal contract — phpName => [wireKey, shape]. See ADR-007.
     * @var array<string, array{0: string, 1: null|class-string|array{0: string, 1: null|class-string}|array{0: string, 1: list<class-string>, 2: ?string}}>
     */
    public const array PROPERTY_MAP = [
        'billable' => ['billable', \Acme\GitHub\Generated\Model\WorkflowRunUsageBillable::class],
        'run_duration_ms' => ['run_duration_ms', null],
    ];

    public function __construct(
        public WorkflowRunUsageBillable $billable,
        public ?int $run_duration_ms = null,
    ) {
    }

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'billable' => $this->billable,
            'run_duration_ms' => $this->run_duration_ms,
        ];
    }
}
