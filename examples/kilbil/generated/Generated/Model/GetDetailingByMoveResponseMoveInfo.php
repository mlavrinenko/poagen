<?php

declare(strict_types=1);

namespace Acme\Kilbil\Generated\Model;

use Acme\Kilbil\Generated\Enum\GetDetailingByMoveResponseMoveInfoOperType;
use Acme\Kilbil\ValueObject\Timestamp;

final readonly class GetDetailingByMoveResponseMoveInfo
{
    /**
     * @param ?list<\Acme\Kilbil\Generated\Model\GetDetailingByMoveResponseMoveInfoBonusInDetailItem> $bonus_in_detail
     * @param ?list<\Acme\Kilbil\Generated\Model\GetDetailingByMoveResponseMoveInfoBonusPresentsItem> $bonus_presents
     * @param ?list<\Acme\Kilbil\Generated\Model\GetDetailingByMoveResponseMoveInfoMoveActionsItem> $move_actions
     * @param ?list<string> $promo_codes
     */
    public function __construct(
        public ?float $bonus_in = null,
        public ?array $bonus_in_detail = null,
        public ?float $bonus_out = null,
        public ?array $bonus_presents = null,
        public ?float $cash_discount = null,
        public ?int $client_id = null,
        public ?float $discount = null,
        public ?int $id = null,
        public ?bool $is_confirmed = null,
        public ?bool $is_reserved = null,
        public ?array $move_actions = null,
        public ?float $move_asum = null,
        public ?Timestamp $move_date = null,
        public ?string $move_id = null,
        public ?float $move_total = null,
        public ?GetDetailingByMoveResponseMoveInfoOperType $oper_type = null,
        public ?array $promo_codes = null,
        public ?int $shift_number = null,
    ) {
    }
}
