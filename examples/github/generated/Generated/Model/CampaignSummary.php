<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

use Acme\GitHub\Generated\Enum\CampaignState;
use DateTimeImmutable;

final readonly class CampaignSummary
{
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
}
