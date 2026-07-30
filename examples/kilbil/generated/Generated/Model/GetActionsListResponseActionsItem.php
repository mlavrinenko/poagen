<?php

declare(strict_types=1);

namespace Acme\Kilbil\Generated\Model;

use Acme\Kilbil\Generated\Enum\GetActionsListResponseActionsItemWeekDaysItem;
use DateTimeImmutable;
use Mlavrinenko\Paogen\Runtime\Attribute\Format;

final readonly class GetActionsListResponseActionsItem
{
    /**
     * @param ?list<string> $actions_programs
     * @param ?list<GetActionsListResponseActionsItemRespondsItem> $responds
     * @param ?list<string> $trade_objects
     * @param ?list<GetActionsListResponseActionsItemWeekDaysItem> $week_days
     */
    public function __construct(
        public ?string $action = null,
        #[Format('date')]
        public ?DateTimeImmutable $action_begin = null,
        #[Format('date')]
        public ?DateTimeImmutable $action_end = null,
        public ?array $actions_programs = null,
        public ?string $auth_type = null,
        public ?int $id = null,
        public ?array $responds = null,
        public ?string $run_count_limit = null,
        public ?string $run_count_limit_client = null,
        public ?string $time_limit_begin = null,
        public ?string $time_limit_end = null,
        public ?array $trade_objects = null,
        public ?array $week_days = null,
    ) {
    }
}
