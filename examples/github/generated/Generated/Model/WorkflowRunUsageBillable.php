<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

use JsonSerializable;

final readonly class WorkflowRunUsageBillable implements JsonSerializable
{
    /**
     * Paogen marshal/unmarshal contract — phpName => [wireKey, shape]. See ADR-007.
     * @var array<string, array{0: string, 1: null|class-string|array{0: string, 1: null|class-string}|array{0: string, 1: list<class-string>, 2: ?string}}>
     */
    public const array PROPERTY_MAP = [
        'MACOS' => ['MACOS', \Acme\GitHub\Generated\Model\WorkflowRunUsageBillableMACOS::class],
        'UBUNTU' => ['UBUNTU', \Acme\GitHub\Generated\Model\WorkflowRunUsageBillableUBUNTU::class],
        'WINDOWS' => ['WINDOWS', \Acme\GitHub\Generated\Model\WorkflowRunUsageBillableWINDOWS::class],
    ];

    public function __construct(
        public ?WorkflowRunUsageBillableMACOS $MACOS = null,
        public ?WorkflowRunUsageBillableUBUNTU $UBUNTU = null,
        public ?WorkflowRunUsageBillableWINDOWS $WINDOWS = null,
    ) {
    }

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'MACOS' => $this->MACOS,
            'UBUNTU' => $this->UBUNTU,
            'WINDOWS' => $this->WINDOWS,
        ];
    }
}
