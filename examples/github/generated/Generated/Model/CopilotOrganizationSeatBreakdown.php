<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

use JsonSerializable;

final readonly class CopilotOrganizationSeatBreakdown implements JsonSerializable
{
    /**
     * Paogen marshal/unmarshal contract — phpName => [wireKey, shape]. See ADR-007.
     * @var array<string, array{0: string, 1: null|class-string|array{0: string, 1: null|class-string}|array{0: string, 1: list<class-string>, 2: ?string}}>
     */
    public const array PROPERTY_MAP = [
        'active_this_cycle' => ['active_this_cycle', null],
        'added_this_cycle' => ['added_this_cycle', null],
        'inactive_this_cycle' => ['inactive_this_cycle', null],
        'pending_cancellation' => ['pending_cancellation', null],
        'pending_invitation' => ['pending_invitation', null],
        'total' => ['total', null],
    ];

    public function __construct(
        public ?int $active_this_cycle = null,
        public ?int $added_this_cycle = null,
        public ?int $inactive_this_cycle = null,
        public ?int $pending_cancellation = null,
        public ?int $pending_invitation = null,
        public ?int $total = null,
    ) {
    }

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'active_this_cycle' => $this->active_this_cycle,
            'added_this_cycle' => $this->added_this_cycle,
            'inactive_this_cycle' => $this->inactive_this_cycle,
            'pending_cancellation' => $this->pending_cancellation,
            'pending_invitation' => $this->pending_invitation,
            'total' => $this->total,
        ];
    }
}
