<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

use JsonSerializable;

final readonly class WorkflowUsageBillable implements JsonSerializable
{
    /**
     * Paogen marshal/unmarshal contract — phpName => [wireKey, shape]. See ADR-007.
     * @var array<string, array{0: string, 1: null|class-string|array{0: string, 1: null|class-string}|array{0: string, 1: list<class-string>, 2: ?string}}>
     */
    public const array PROPERTY_MAP = [
        'MACOS' => ['MACOS', \Acme\GitHub\Generated\Model\WorkflowUsageBillableMACOS::class],
        'UBUNTU' => ['UBUNTU', \Acme\GitHub\Generated\Model\WorkflowUsageBillableUBUNTU::class],
        'WINDOWS' => ['WINDOWS', \Acme\GitHub\Generated\Model\WorkflowUsageBillableWINDOWS::class],
    ];

    public function __construct(
        public ?WorkflowUsageBillableMACOS $MACOS = null,
        public ?WorkflowUsageBillableUBUNTU $UBUNTU = null,
        public ?WorkflowUsageBillableWINDOWS $WINDOWS = null,
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
