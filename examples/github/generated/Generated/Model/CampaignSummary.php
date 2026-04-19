<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

use Acme\GitHub\Generated\Enum\CampaignState;
use DateTimeImmutable;
use JsonSerializable;

final readonly class CampaignSummary implements JsonSerializable
{
    /**
     * Paogen marshal/unmarshal contract — phpName => [wireKey, shape]. See ADR-007.
     * @var array<string, array{0: string, 1: null|class-string|array{0: string, 1: null|class-string}|array{0: string, 1: list<class-string>, 2: ?string}}>
     */
    public const array PROPERTY_MAP = [
        'contact_link' => ['contact_link', null],
        'created_at' => ['created_at', ['datetime', null]],
        'description' => ['description', null],
        'ends_at' => ['ends_at', ['datetime', null]],
        'managers' => ['managers', ['list', \Acme\GitHub\Generated\Model\SimpleUser::class]],
        'number' => ['number', null],
        'state' => ['state', ['enum', \Acme\GitHub\Generated\Enum\CampaignState::class]],
        'updated_at' => ['updated_at', ['datetime', null]],
        'alert_stats' => ['alert_stats', \Acme\GitHub\Generated\Model\CampaignSummaryAlert_stats::class],
        'closed_at' => ['closed_at', ['datetime', null]],
        'name' => ['name', null],
        'published_at' => ['published_at', ['datetime', null]],
        'team_managers' => ['team_managers', ['list', \Acme\GitHub\Generated\Model\Team::class]],
    ];

    /**
     * @param list<\Acme\GitHub\Generated\Model\SimpleUser> $managers
     * @param ?list<\Acme\GitHub\Generated\Model\Team> $team_managers
     */
    public function __construct(
        public ?string $contact_link = null,
        public DateTimeImmutable $created_at,
        public string $description,
        public DateTimeImmutable $ends_at,
        public array $managers,
        public int $number,
        public CampaignState $state,
        public DateTimeImmutable $updated_at,
        public ?CampaignSummaryAlert_stats $alert_stats = null,
        public ?DateTimeImmutable $closed_at = null,
        public ?string $name = null,
        public ?DateTimeImmutable $published_at = null,
        public ?array $team_managers = null,
    ) {
    }

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'contact_link' => $this->contact_link,
            'created_at' => $this->created_at->format(\DateTimeInterface::RFC3339),
            'description' => $this->description,
            'ends_at' => $this->ends_at->format(\DateTimeInterface::RFC3339),
            'managers' => $this->managers,
            'number' => $this->number,
            'state' => $this->state,
            'updated_at' => $this->updated_at->format(\DateTimeInterface::RFC3339),
            'alert_stats' => $this->alert_stats,
            'closed_at' => $this->closed_at?->format(\DateTimeInterface::RFC3339),
            'name' => $this->name,
            'published_at' => $this->published_at?->format(\DateTimeInterface::RFC3339),
            'team_managers' => $this->team_managers,
        ];
    }
}
