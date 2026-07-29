<?php

declare(strict_types=1);

namespace Acme\Kilbil\Generated\Model;

use Acme\Kilbil\Generated\Enum\ExchangePosSettingsRequestAutoupdate;

final readonly class ExchangePosSettingsRequest
{
    public function __construct(
        public string $pos_program,
        public string $version,
        public ?ExchangePosSettingsRequestAutoupdate $autoupdate = null,
    ) {
    }
}
