<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

use DateTimeImmutable;
use JsonSerializable;

final readonly class CopilotSeatDetails implements JsonSerializable
{
    /**
     * Paogen marshal/unmarshal contract — phpName => [wireKey, shape]. See ADR-007.
     * @var array<string, array{0: string, 1: null|class-string|array{0: string, 1: null|class-string}|array{0: string, 1: list<class-string>, 2: ?string}}>
     */
    public const array PROPERTY_MAP = [
        'created_at' => ['created_at', ['datetime', null]],
        'assignee' => ['assignee', \Acme\GitHub\Generated\Model\NullableSimpleUser::class],
        'assigning_team' => [
            'assigning_team',
            ['union', [\Acme\GitHub\Generated\Model\Team::class, \Acme\GitHub\Generated\Model\EnterpriseTeam::class], null],
        ],
        'last_activity_at' => ['last_activity_at', ['datetime', null]],
        'last_activity_editor' => ['last_activity_editor', null],
        'last_authenticated_at' => ['last_authenticated_at', ['datetime', null]],
        'organization' => ['organization', \Acme\GitHub\Generated\Model\NullableOrganizationSimple::class],
        'pending_cancellation_date' => ['pending_cancellation_date', ['date', null]],
        'plan_type' => ['plan_type', null],
        'updated_at' => ['updated_at', ['datetime', null]],
    ];

    public function __construct(
        public DateTimeImmutable $created_at,
        public ?NullableSimpleUser $assignee = null,
        public Team|EnterpriseTeam|null $assigning_team = null,
        public ?DateTimeImmutable $last_activity_at = null,
        public ?string $last_activity_editor = null,
        public ?DateTimeImmutable $last_authenticated_at = null,
        public ?NullableOrganizationSimple $organization = null,
        public ?DateTimeImmutable $pending_cancellation_date = null,
        public ?string $plan_type = null,
        public ?DateTimeImmutable $updated_at = null,
    ) {
    }

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'created_at' => $this->created_at->format(\DateTimeInterface::RFC3339),
            'assignee' => $this->assignee,
            'assigning_team' => $this->assigning_team,
            'last_activity_at' => $this->last_activity_at?->format(\DateTimeInterface::RFC3339),
            'last_activity_editor' => $this->last_activity_editor,
            'last_authenticated_at' => $this->last_authenticated_at?->format(\DateTimeInterface::RFC3339),
            'organization' => $this->organization,
            'pending_cancellation_date' => $this->pending_cancellation_date?->format('Y-m-d'),
            'plan_type' => $this->plan_type,
            'updated_at' => $this->updated_at?->format(\DateTimeInterface::RFC3339),
        ];
    }
}
