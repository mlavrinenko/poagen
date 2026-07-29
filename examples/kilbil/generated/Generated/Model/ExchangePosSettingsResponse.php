<?php

declare(strict_types=1);

namespace Acme\Kilbil\Generated\Model;

use Acme\Kilbil\Generated\Enum\ExchangePosSettingsResponseOsmiCardsAreUsed;
use Acme\Kilbil\Generated\Enum\ExchangePosSettingsResponseSaveNonbonusMoves;

final readonly class ExchangePosSettingsResponse
{
    public function __construct(
        public string $result_code,
        public ?ExchangePosSettingsResponseOsmiCardsAreUsed $osmi_cards_are_used = null,
        public ?ExchangePosSettingsResponseRegistrationFields $registration_fields = null,
        public ?ExchangePosSettingsResponseSaveNonbonusMoves $save_nonbonus_moves = null,
    ) {
    }
}
