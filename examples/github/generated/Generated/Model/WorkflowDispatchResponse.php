<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

use JsonSerializable;

final readonly class WorkflowDispatchResponse implements JsonSerializable
{
    /**
     * Paogen marshal/unmarshal contract — phpName => [wireKey, shape]. See ADR-007.
     * @var array<string, array{0: string, 1: null|class-string|array{0: string, 1: null|class-string}|array{0: string, 1: list<class-string>, 2: ?string}}>
     */
    public const array PROPERTY_MAP = [
        'html_url' => ['html_url', null],
        'run_url' => ['run_url', null],
        'workflow_run_id' => ['workflow_run_id', \Acme\GitHub\Generated\Model\WorkflowRunId::class],
    ];

    public function __construct(
        public string $html_url,
        public string $run_url,
        public WorkflowRunId $workflow_run_id,
    ) {
    }

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'html_url' => $this->html_url,
            'run_url' => $this->run_url,
            'workflow_run_id' => $this->workflow_run_id,
        ];
    }
}
